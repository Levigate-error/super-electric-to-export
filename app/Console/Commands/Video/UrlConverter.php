<?php

namespace App\Console\Commands\Video;

use App\Models\Video\Video;
use App\Utils\YouTubeLinkConverter;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class UrlConverter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:convert-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Формирует валидный url для воспроизведения видео с youtube.';

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

        $this->info('Start convert video url');

        $videoCount = Video::query()->count();

        $progressBar = new ProgressBar($this->output);
        $progressBar->start($videoCount);

        Video::query()->chunk(10, static function (Collection $videos) use ($progressBar) {
            foreach ($videos as $video) {
                $video->video = YouTubeLinkConverter::convert($video->video);
                $video->save();
                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->info(PHP_EOL . 'Done');
    }
}
