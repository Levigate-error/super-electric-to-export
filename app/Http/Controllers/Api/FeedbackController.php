<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\FeedbackServiceContract;
use App\Http\Requests\FeedbackRequest;

/**
 * Class FeedbackController
 * @package App\Http\Controllers\Api
 */
class FeedbackController extends BaseApiController
{
    /**
     * @var FeedbackServiceContract
     */
    private $service;

    /**
     * AnalogueController constructor.
     * @param FeedbackServiceContract $service
     */
    public function __construct(FeedbackServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {post} api/feedback Создать фидбэк
     * @apiName        FeedbackCreate
     * @apiGroup       Feedback
     * @apiDescription создает фидбэк
     *
     * @apiParam  {string}   email      E-mail
     * @apiParam  {string}   text       Текст
     * @apiParam  {string}   name       Имя
     * @apiParam  {string}   type       Тип. Может быть common и help. help - когда со страницы помощь. common - когда из футера.
     * @apiParam  {file}     [file]     Файл
     *
     * @apiSuccess  {integer}  id         ID
     * @apiSuccess  {string}   email      E-mail
     * @apiSuccess  {string}   name       Имя
     * @apiSuccess  {string}   text       Текст
     * @apiSuccess  {string}   status     Статус
     * @apiSuccess  {string}   file_url   Ссылка на файл
     * @apiSuccess  {string}   type       Тип
     *
     * @param FeedbackRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function store(FeedbackRequest $request): array
    {
        $this->authorize('create', $this->service->getRepository()->getSource());

        return $this->service->createFeedback($request->validated());
    }
}
