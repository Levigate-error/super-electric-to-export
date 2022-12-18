<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\Project\Project;

/**
 * Class UserActivityTest
 * @package Tests\Feature\Models
 */
class UserActivityTest extends TestCase
{
    /**
     * Проверка корректного формирования заголовка
     */
    public function testSuccessGetTitleAttribute(): void
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);
        $userActivity = factory(UserActivity::class)->create([
            'user_id' => $project->user_id,
            'source_id' => $project->id,
            'source_type' => $project->getMorphClass(),
        ]);

        $this->assertEquals($userActivity->title, $project->title);
    }

    /**
     * Проверка формирования заголовка при не корректной записи активности
     */
    public function testNotSuccessGetTitleAttribute(): void
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);
        $userActivity = factory(UserActivity::class)->create([
            'user_id' => $project->user_id,
            'source_id' => $project->id,
            'source_type' => 'not correct source type',
        ]);

        $this->assertNotEquals($userActivity->title, $project->title);

        $this->assertEquals($userActivity->title, '');
    }
}
