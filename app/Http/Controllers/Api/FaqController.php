<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Faq\FaqGetRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\FaqServiceContract;

/**
 * Class FaqController
 * @package App\Http\Controllers\Api
 */
class FaqController extends BaseApiController
{
    /**
     * @var FaqServiceContract
     */
    private $service;


    /**
     * FaqController constructor.
     * @param FaqServiceContract $service
     */
    public function __construct(FaqServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {post} api/faq/get-faqs Список вопросов
     * @apiName        GetFaqs
     * @apiGroup       Faq
     * @apiDescription Возвращает список вопросов-ответов
     *
     * @apiSuccess  {integer}   total                   Всего записей
     * @apiSuccess  {integer}   lastPage                Последняя страница
     * @apiSuccess  {integer}   currentPage             Текущая страница
     * @apiSuccess  {array}     faqs                    Вопросы
     * @apiSuccess  {integer}   faqs.id                 ID
     * @apiSuccess  {string}    faqs.question           Вопрос
     * @apiSuccess  {string}    faqs.answer             Ответ
     * @apiSuccess  {string}    faqs.created_at         Дата создания
     *
     * @apiParam  {integer}  [limit]                Кол-ство записей. По умолчанию 15.
     * @apiParam  {integer}  [page]                 Страница
     *
     * @param FaqGetRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function getFaqs(FaqGetRequest $request): array
    {
        $this->authorize('index', $this->service->getRepository()->getSource());

        return $this->service->getFaqsByParams($request->validated());
    }
}
