<?php

namespace Tests\Feature\Service\Project;

use App\Models\Project\Project;
use Tests\TestCase;
use App\Models\User;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;

/**
 * Class UserActivityTest
 * @package Tests\Feature\Service\Project
 */
class UserActivityTest extends TestCase
{
    /**
     * Проверка на добавление в активность юзера проекта
     */
    public function testSuccessAddUserProjectActivity(): void
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);

        $this->be($user);

        $service = app()->make(ProjectServiceContract::class);
        $service->addCurrentUserActivity($project->id);

        $this->assertDatabaseHas('user_activities', [
            'user_id' => $user->id,
            'source_id' => $project->id,
            'source_type' => Project::class,
        ]);
    }
}
