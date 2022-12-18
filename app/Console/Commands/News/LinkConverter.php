<?php

namespace App\Console\Commands\News;

use App\Domain\UtilContracts\HtmlLinkConverterContract;
use App\Models\News;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class LinkConverter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:convert-string-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Заменяет строковые ссылки на html ссылки в описание новостей.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('Do you wish to continue?')) {
            return;
        }

        $this->info('Start convert string link to html link in news description');

        $newsCollection = News::query()->get();

        $progressBar = new ProgressBar($this->output);
        $progressBar->start($newsCollection->count());

        foreach ($newsCollection as $news) {
            $news->description = \HtmlLinkConverter::convert($news->description, HtmlLinkConverterContract::TARGET_BLANK);
            $news->save();
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info(PHP_EOL . 'Done');
    }
}
