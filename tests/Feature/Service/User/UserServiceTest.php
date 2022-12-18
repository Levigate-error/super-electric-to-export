<?php

namespace Tests\Feature\Service\User;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Tests\TestCase;
use App\Models\User;
use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Models\Certificate;
use Tests\Feature\Traits\Loyaltyable;

/**
 * Class UserServiceTest
 * @package Tests\Feature\Service\User
 */
class UserServiceTest extends TestCase
{
    use Loyaltyable;

    /**
     * @var UserServiceContract
     */
    protected $service;

    /**
     * @throws BindingResolutionException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->service = app()->make(UserServiceContract::class);
    }

    /**
     * Проверка удаления юзера
     */
    public function testSuccessDeleteUser(): void
    {
        $user = factory(User::class)->create();

        $result = $this->service->deleteUser($user->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * Проверка на полноту данных юзера
     */
    public function testCompletenessUserData(): void
    {
        $user = factory(User::class)->create(['photo' => 'correct_photo.png',]);
        $certificate = factory(Certificate::class)->create();
        $user->certificates()->attach($certificate);

        $this->registerInLoyaltyProgram($user);

        /**
         * @var $result Collection
         */
        $result = $this->service->checkUserDataCompleteness($user->id);

        $this->assertTrue($result->isEmpty());
    }

    /**
     * Проверка на не полноту данных юзера
     */
    public function testNotCompletenessUserData(): void
    {
        $user = factory(User::class)->create();

        /**
         * @var $result Collection
         */
        $result = $this->service->checkUserDataCompleteness($user->id);

        $this->assertTrue($result->isNotEmpty());
    }

    /**
     * Получение опубликованных пользователей
     */
    public function testGetPublishedElectrician(): void
    {
        factory(User::class)->create();

        $this->assertEmpty($this->service->getPublishedElectrician());

        $user = factory(User::class)->create([
            'photo' => 'correct_photo.png',
        ]);

        $this->registerInLoyaltyProgram($user);

        $this->assertNotEmpty($this->service->getPublishedElectrician());

        /**
         * Устанавливаем флаг запрета
         */
        $user->publish_ban = true;
        $user->save();

        $this->assertEmpty($this->service->getPublishedElectrician());
    }
}
