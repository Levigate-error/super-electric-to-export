<?php

namespace Tests\Feature\Http\Controllers\Api\Test;

use App\Models\Test\Test;
use App\Models\Test\TestUser;
use App\Models\User;
use Tests\TestCase;
use Tests\Feature\Traits\Testable;

/**
 * Class TestTest
 * @package Tests\Feature\Http\Controllers\Api\Test
 */
class TestTest extends TestCase
{
    use Testable;

    public function testGetTests(): void
    {
        Test::query()->truncate();

        $publishedTests = factory(Test::class, 5)->create(['published' => true]);
        factory(Test::class, 3)->create(['published' => false]);

        $response = $this->json('GET', route('api.tests.get-tests'));

        $firstTest = $publishedTests->first();

        $response
            ->assertStatus(200)
            ->assertJsonCount($publishedTests->count())
            ->assertJsonFragment([
                'id' => $firstTest->id,
                'title' => $firstTest->title,
                'image' => $firstTest->imagePath,
                'description' => $firstTest->description,
                'questions' => [],
                'created_at' => $firstTest->created_at->toIso8601String(),
            ]);
    }

    public function testDetails(): void
    {
        $test = factory(Test::class)->create(['published' => true]);

        $response = $this->json('GET', route('api.tests.get-details', ['id' => $test->id]));

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $test->id,
                'title' => $test->title,
                'image' => $test->imagePath,
                'description' => $test->description,
                'questions' => [],
                'created_at' => $test->created_at->toIso8601String(),
            ]);
    }

    public function testRegisterTest(): void
    {
        $user = factory(User::class)->create();
        $test = $this->prepareFullTestData();
        $mixedTestData = $this->prepareParamsAndCorrectResponse($test);

        $response = $this->actingAs($user)
            ->json('POST', route('api.tests.register-test', ['id' => $test['main']['id']]), $mixedTestData['params']);

        $response->assertStatus(200)
            ->assertJsonStructure(['test', 'result', 'points_result']);

        $this->assertDatabaseHas('tests_users', [
            'test_id' => $test['main']['id'],
            'user_id' => $user->id,
        ]);


        $testUser = TestUser::query()
            ->where([
                'test_id' => $test['main']['id'],
                'user_id' => $user->id,
            ])
            ->latest()
            ->first();

        foreach ($mixedTestData['correctAnswersData'] as $correctAnswer) {
            $this->assertDatabaseHas('tests_users_test_answers', [
                'test_user_id' => $testUser->id,
                'test_answer_id' => $correctAnswer['id'],
            ]);
        }
    }
}
