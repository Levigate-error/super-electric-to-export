<?php

namespace App\Services;

use App\Domain\ServiceContracts\FeedbackServiceContract;
use App\Domain\ServiceContracts\Log\CreateLogServiceContract;
use App\Domain\Repositories\FeedbackRepositoryContract;
use App\Http\Resources\FeedbackResource;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use App\Domain\Dictionaries\Feedback\FeedbackStatuses;
use Illuminate\Support\Facades\Storage;

/**
 * Class FeedbackService
 * @package App\Services
 */
class FeedbackService extends BaseService implements FeedbackServiceContract
{
    protected const FILE_DIR = 'feedback' . DIRECTORY_SEPARATOR;

    /**
     * @var FeedbackRepositoryContract
     */
    private $repository;

    /**
     * FeedbackService constructor.
     * @param FeedbackRepositoryContract $repository
     */
    public function __construct(FeedbackRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return FeedbackRepositoryContract
     */
    public function getRepository(): FeedbackRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return array
     */
    public function createFeedback(array $params): array
    {
        if (Auth::user() !== null) {
            $params['user_id'] = Auth::user()->id;
        }

        $params['status'] = FeedbackStatuses::NEW;

        if (isset($params['file']) === true) {
            $filePath = $this->generateFilePath($params['file']);
            Storage::disk('public')->put($filePath, $params['file']->get());

            $params['file'] = $filePath;
        }

        $feedback = $this->repository->getSource()::create($params);

        return FeedbackResource::make($feedback)->resolve();
    }

    /**
     * Обязательна ли recaptcha
     *
     * @return bool
     * @throws BindingResolutionException
     */
    public function isRecaptchaRequired(): bool
    {
        $clientUserAgent = request()->header('user-agent');

        /** @var CreateLogServiceContract $createLogService */
        $createLogService = app()->make(CreateLogServiceContract::class);

        $createdCount = $createLogService->getCreatedCount($clientUserAgent, $this->repository->getSource());

        return $createdCount >= config('feedback.max_create_count_per_day');
    }
}
