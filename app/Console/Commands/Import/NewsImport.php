<?php

namespace App\Console\Commands\Import;

use App\Helpers\HtmlTagHelper;
use App\Mail\ImportNews;
use App\Models\News;
use App\Utils\HtmlLinkConverter;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class NewsImport
 *
 * @package App\Console\Commands\Import
 */
class NewsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import news from legrand.ru';

    protected $address = 'https://legrand.ru';

    protected $pages = [
        'new'   => 'https://legrand.ru/press/newslist/',
        'media' => 'https://legrand.ru/press/massmedia/',
        'event' => 'https://legrand.ru/press/partners_events/',
    ];

    /**
     * @var string
     */
    protected $sourceBaseUrl = 'https://legrand.ru';

    protected $importNews = [];

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): bool
    {
        $this->info('Start news import');

        $news = [];
        foreach ($this->pages as $key => $value) {
            $this->info('Parse page: ' . $value);
            $news[] = $this->getNews($value);
        }

        $news = array_merge([], ... $news);

        if (!$news) {
            $this->info('Error with get news');
            return false;
        }

        $this->updateNews($news);

        $this->info('Done news import');

        if ($this->importNews) {
            $this->info('Sending a letter about new news');
            $this->sendMail($this->importNews);
        }

        return true;
    }

    /**
     * Парсим страницу новостей по урлу
     *
     * @param string $url
     *
     * @return array
     */
    protected function getNews(string $url): array
    {
        $records = [];
        $document = $this->getDocument($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($document);
        $xpath = new DOMXPath($dom);
        $paginate = $url . '?PAGEN_1=';
        $nextPage = 1;
        $lastPage = 1;
        $pBlock = $xpath->query('(//div[@class="b-pagination-arrow__page-item"])[last()]');
        foreach ($pBlock as $item) {
            $lastPage = $item->nodeValue;
        }

        do {
            $url = $paginate . $nextPage;
            $document = $this->getDocument($url);
            $dom->loadHTML($document);
            $xpath = new DOMXPath($dom);
            $listNews = $this->getListNews($xpath);
            $records[] = $listNews;
            $nextPage++;
        } while ($lastPage >= $nextPage);

        $records = array_merge([], ... $records);

        $recordsCount = count($records);
        $this->info('Count: ' . $recordsCount);

        $progressBar = new ProgressBar($this->output);
        $progressBar->start($recordsCount);
        foreach ($records as $i => $record) {
            $records[$i] = $this->getOneNews($record);
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->info(PHP_EOL);

        return $records;
    }

    /**
     * Получение 1 новости
     *
     * @param string $url
     *
     * @return array
     */
    protected function getOneNews(string $url): array
    {
        $document = $this->getDocument($this->address . $url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($document);
        $xpath = new DOMXPath($dom);

        $record = [];
        $record['id'] = $this->getId($url);
        $record['source'] = $this->address . $url;
        $record['date'] = $this->getInnerElementContentByExpression($xpath, '//div[@class="press-detail__date"]');
        $record['title'] = $this->getInnerElementContentByExpression($xpath, '//h1[@class="press-detail__title"]');
        $record['anons'] = $this->getInnerElementContentByExpression($xpath, '//div[@class="press-detail__intro"]');

        $record['text'] = $this->getInnerElementContentByExpression(
            $xpath,
            '//div[@class="press-detail__text"]',
            $dom,
            true,
            false
        );

        $record['img'] = $this->getInnerElementContentByExpression($xpath, '//img[@class="press-detail__img"]/@src');

        $moreLink = $this->getInnerElementContentByExpression(
            $xpath,
            '//a[@class="press-detail__btn press-detail__btn_dark"]/@href'
        );

        $record['more_link'] = ($moreLink === '') ? null : $moreLink;

        if (empty($record['text'])) {
            $record['text'] = $this->getInnerElementContentByExpression(
                $xpath,
                '//div[@class="press-detail__text"]/iframe',
                true,
                false
            );
        }

        return $record;
    }

    /**
     * Получение id страницы
     *
     * @param string $url
     *
     * @return string
     */
    protected function getId(string $url): string
    {
        $id = '';
        $arrUrl = explode('/', $url);
        if ($arrUrl) {
            $i = 1;
            do {
                $id = $arrUrl[count($arrUrl) - $i];
                $i++;
            } while (empty($id) || !is_numeric($id));
        }

        return $id;
    }

    /**
     * Получение контента элемента страницы
     *
     * @param DOMXPath $xpath
     * @param string $expression
     * @param boolean $withTags
     * @param boolean $deleteTransistions
     * @return string
     */

    protected function getInnerElementContentByExpression(
        DOMXPath $xpath,
        string $expression,
        $withTags = false,
        $deleteTransistions = true
    ): string {
        $innerContent = '';
        $element = $xpath->query($expression)[0];

        if (!$element) {
            return $innerContent;
    }

        if (!$withTags) {
            $innerContent = $element->textContent;
        } else {
            $children = $element->childNodes;
            foreach ($children as $child) {
                $innerContent .= $xpath->document->saveHTML($child);
            }
        }

        return $deleteTransistions ? delete_transitions_from_text($innerContent) : $innerContent;
    }
    /**
     * Получение списка ссылок на страницы новостей
     *
     * @param DOMXPath $xpath
     *
     * @return array
     */
    protected function getListNews(DOMXPath $xpath): array
    {
        $records = [];
        $list = $xpath->query('//a[@class="press__readmore-link"]');
        foreach ($list as $item) {
            $records[] = $item->getAttribute('href');
        }

        return $records;
    }

    /**
     * Получение страницы
     *
     * @param string $url
     *
     * @return string
     */
    protected function getDocument(string $url): string
    {
        $client = new GuzzleClient();

        $response = $client->request('GET', $url);

        if ($response->getStatusCode() !== 200) {
            return '';
        }

        return $response->getBody();
    }


    /**
     * Обновление новостей
     *
     * @param array $news
     *
     * @throws Exception
     */
    protected function updateNews(array $news): void
    {
        $this->info('Update news');

        $newsCount = count($news);
        $this->info('News count: ' . $newsCount);

        $progressBar = new ProgressBar($this->output);
        $progressBar->start($newsCount);

        foreach ($news as $item) {
            if (empty($item['id'])) {
                continue;
            }

            $currentNews = News::query()->where('source', $item['source'])->first();

            if ($currentNews !== null) {
                continue;
            }

            $image = $this->saveImage($this->address . $item['img'], md5($item['img']));
            $currentNews = new News();
            $currentNews::unguard();

            if (empty($item['text']) === false) {
                $description = HtmlLinkConverter::convert($item['text'], HtmlTagHelper::TARGET_BLANK);
            } else {
                $description = HtmlLinkConverter::convert($item['anons'], HtmlTagHelper::TARGET_BLANK);
            }

            if ($item['more_link'] !== null) {
                $description = $this->addMoreLink($description, $item['more_link']);
            }

            $currentNews->fill([
                'title'             => $item['title'],
                'description'       => $description,
                'short_description' => $item['anons'],
                'image'             => $image,
                'source'            => $item['source'],
                'published'         => false,
                'created_at'        => Carbon::parse($item['date']),
            ]);

            $currentNews->trySaveModel();
            $currentNews::reguard();
            $this->importNews[] = implode(';',
                ['id' => $currentNews->id, 'title' => $currentNews->title, 'source' => $currentNews->source]);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info(PHP_EOL . 'Done');
    }

    /**
     * Сохранение изображения
     *
     * @param string $url
     * @param string $fileName
     *
     * @return string
     * @throws Exception
     */
    protected function saveImage(string $url, string $fileName): string
    {
        $directory = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR);
        if (!file_exists($directory)) {
            if (!mkdir($directory, 0775, true) && !is_dir($directory)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $directory));
            }

            if (!is_writable($directory)) {
                throw new RuntimeException('Directory is not writable');
            }
        }
        $imagePath = 'news' . DIRECTORY_SEPARATOR . $fileName . '.' . pathinfo($url, PATHINFO_EXTENSION);

        $client = new GuzzleClient();

        $response = $client->request('GET', $url, [
            'sink' => $directory . DIRECTORY_SEPARATOR . $fileName . '.' . pathinfo($url, PATHINFO_EXTENSION),
        ]);

        if ($response->getStatusCode() !== 200) {
            return '';
        }

        return $imagePath;
    }

    /**
     * Отправка письма о новых добавленных новостях
     *
     * @param array $news
     *
     * @throws Exception
     */
    protected function sendMail(array $news): void
    {
        Mail::send(new ImportNews($news));
    }

    /**
     * Добавляем в конце описания новости ссылку на источник.
     *
     * @param string $description
     * @param string $moreLink
     *
     * @return string
     */
    protected function addMoreLink(string $description, string $moreLink): string
    {
        if(filter_var($moreLink, FILTER_VALIDATE_URL) === false) {
            $moreLink = $this->sourceBaseUrl . $moreLink;
        }

        $moreHtmlLink = HtmlTagHelper::a($moreLink, $moreLink, HtmlTagHelper::TARGET_BLANK);
        return "$description<br>Подробнее: $moreHtmlLink";
    }
}
