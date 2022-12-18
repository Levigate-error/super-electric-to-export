<?php

namespace Tests\Feature\Service\Feedback;

use App\Models\Feedback;
use App\Models\Log\CreateLog;
use Tests\TestCase;
use App\Domain\ServiceContracts\FeedbackServiceContract;

/**
 * Class FeedbackServiceTest
 * @package Tests\Feature\Service\Feedback
 */
class FeedbackServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app()->make(FeedbackServiceContract::class);
    }

    /**
     * Необходима ли recaptcha. Она становится нужной, когда есть максимально допустимое кол-ство записей
     */
    public function testIsRecaptchaRequired(): void
    {
        $maxTry = config('feedback.max_create_count_per_day');

        CreateLog::query()->truncate();

        /**
         * Создадим записей в логах на один меньше, чем можно
         */
        factory(CreateLog::class, $maxTry-1)->create([
            'client' => request()->header('user-agent'),
            'logable_type' => Feedback::class,
        ]);
        $this->assertFalse($this->service->isRecaptchaRequired());

        /**
         * Теперь добавим запись, чтобы стало максимально допустимое кол-ство
         */
        factory(CreateLog::class, 1)->create([
            'client' => request()->header('user-agent'),
            'logable_type' => Feedback::class,
        ]);
        $this->assertTrue($this->service->isRecaptchaRequired());
    }
}
