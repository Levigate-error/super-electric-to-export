<?php

namespace Tests\Feature\Http\Controllers\Api\User;

use App\Models\Certificate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use Tests\Feature\Traits\Loyaltyable;

/**
 * Class UserTest
 * @package Tests\Feature\Http\Controllers\Api\User
 */
class UserTest extends TestCase
{
    use Loyaltyable;

    /**
     * Проверка самоудаления пользователя
     */
    public function testSuccessUserDelete(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->json('DELETE', route('api.user.delete'));

        $response->assertStatus(200)
            ->assertJson(['result' => true]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * Проверка на загрузку и сохранение фотки пользователя
     */
    public function testSaveUserProfilePhoto(): void
    {
        Storage::fake('public');

        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('photo.png');

        $this->actingAs($user)
            ->json('POST', route('api.user.profile.photo-update'), [
                    'photo' => $file,
                ]
            );

        $user->refresh();

        Storage::disk('public')->assertExists($user->photo);
    }

    /**
     * Проверка на устанавливление флага "опубликован"
     */
    public function testSaveUserProfilePublished(): void
    {
        $user = factory(User::class)->create([
            'photo' => 'correct_photo.png',
            'publish_ban' => true,
        ]);

        $this->registerInLoyaltyProgram($user);

        $this->registerCertificate($user);

        /**
         * Устанавливаем флаг "опубликован" с запретом
         */
        $published = true;
        $response = $this->actingAs($user)
            ->json('PATCH', route('api.user.profile.published-update'), [
                'published' => $published,
            ]);
        $response->assertStatus(422);

        /**
         * Снимаем флаг запрета
         */
        $user->publish_ban = false;
        $user->save();

        /**
         * Устанавливаем флаг "опубликован" без запрета
         */
        $response = $this->actingAs($user)
            ->json('PATCH', route('api.user.profile.published-update'), [
                'published' => $published,
            ]);
        $response->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'published' => $published,
        ]);
    }

    /**
     * Проверка на полноту данных профиля юзера
     */
    public function testProfileCompletenessCheck(): void
    {
        $completeUser = factory(User::class)->create(['photo' => 'correct_photo.png']);

        $response = $this->actingAs($completeUser)
            ->json('GET', route('api.user.profile.completeness-check'));

        $response->assertOk()
            ->assertJson(['result' => true, 'errors' => '']);

        $notCompleteUser = factory(User::class)->create();

        $response = $this->actingAs($notCompleteUser)
            ->json('GET', route('api.user.profile.completeness-check'));

        $response->assertOk()
            ->assertJsonFragment(['result' => false])
            ->assertJsonStructure(['result', 'errors']);
    }

    private function registerCertificate(User $user)
    {
        $certificate = factory(Certificate::class)->create();
        $user->certificates()->attach($certificate);
    }
}
