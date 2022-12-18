<?php

use Illuminate\Database\Seeder;
use App\Models\Project\ProjectStatus;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resource = [
            [
                'title' => 'В работе',
                'slug' => 'in_work',
                'color' => 'green',
            ],
            [
                'title' => 'Планируется',
                'slug' => 'planing',
                'color' => 'yellow',
            ],
            [
                'title' => 'Завершен',
                'slug' => 'completed',
                'color' => 'blue',
            ],
        ];

        foreach ($resource as $status) {
            $projectStatus = new ProjectStatus();
            $projectStatus->fill($status);
            setup_translate($projectStatus);
            $projectStatus->trySaveModel();
        }
    }
}
