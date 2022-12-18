<?php

namespace Tests\Feature\Http\Controllers\Api\Feedback;

use Tests\TestCase;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Domain\Dictionaries\Feedback\FeedbackStatuses;

/**
 * Class FeedbackTest
 * @package Tests\Feature\Http\Controllers\Api\Feedback
 */
class FeedbackTest extends TestCase
{
    protected $file;

    public function setUp(): void
    {
        parent::setUp();

        $this->file = UploadedFile::fake()->image('photo.png');

        Storage::fake('public');
    }

    public function testStoreWithoutUser(): void
    {
        $feedback = factory(Feedback::class)->make([
            'file' => $this->file,
        ])->toArray();

        $response = $this->json('POST', route('api.feedback.store'), $feedback);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'email',
                'name',
                'text',
                'status',
                'file_url',
            ]);

        $this->assertDatabaseHas('feedback', [
            'email' => $feedback['email'],
            'name' => $feedback['name'],
            'text' => $feedback['text'],
            'status' => FeedbackStatuses::NEW,
        ]);

        $feedback = Feedback::query()->where([
            'email' => $feedback['email'],
            'name' => $feedback['name'],
            'text' => $feedback['text'],
            'status' => FeedbackStatuses::NEW,
        ])->first();

        $this->additionalChecks($feedback);
    }

    public function testStoreWithUser(): void
    {
        $user = factory(User::class)->create();

        $feedback = factory(Feedback::class)->make([
            'user_id' => $user->id,
            'file' => $this->file,
        ])->toArray();

        $response = $this->actingAs($user)
            ->json('POST', route('api.feedback.store'), $feedback);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'email',
                'name',
                'text',
                'status',
                'file_url',
            ]);

        $this->assertDatabaseHas('feedback', [
            'user_id' => $user->id,
            'email' => $feedback['email'],
            'name' => $feedback['name'],
            'text' => $feedback['text'],
            'status' => FeedbackStatuses::NEW,
        ]);

        $feedback = Feedback::query()->where([
            'user_id' => $user->id,
            'email' => $feedback['email'],
            'name' => $feedback['name'],
            'text' => $feedback['text'],
            'status' => FeedbackStatuses::NEW,
        ])->first();

        $this->additionalChecks($feedback);
    }

    /**
     * @param Feedback $feedback
     */
    protected function additionalChecks(Feedback $feedback): void
    {
        Storage::disk('public')->assertExists($feedback->file);

        $this->assertDatabaseHas('create_logs', [
            'logable_id' => $feedback->id,
            'logable_type' => Feedback::class,
        ]);
    }

    public function testStoreWithRecaptcha(): void
    {
        $feedback = factory(Feedback::class)->make()->toArray();

        $maxTry = config('feedback.max_create_count_per_day');

        for ($i = 0; $i < $maxTry; $i++) {
            $response = $this->json('POST', route('api.feedback.store'), $feedback);

            $response->assertStatus(200);
        }

        /**
         * После максимального кол-ство разрешенных добавлений фидбеков.
         * Должна быть ошибка об необходимости прохождения recaptcha
         */
        $response = $this->json('POST', route('api.feedback.store'), $feedback);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'g-recaptcha-response'
                ],
            ]);
    }
}
