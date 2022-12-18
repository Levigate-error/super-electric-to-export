<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\News\GetNewsRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\NewsServiceContract;

/**
 * Class NewsController
 * @package App\Http\Controllers\Api
 */
class NewsController extends BaseApiController
{
    /**
     * @var NewsServiceContract
     */
    private $service;


    /**
     * FaqController constructor.
     * @param NewsServiceContract $service
     */
    public function __construct(NewsServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {post} api/news/get-news Список новостей
     * @apiName        GetNews
     * @apiGroup       News
     * @apiDescription Возвращает список новостей
     *
     * @apiSuccess  {integer}   total                   Всего записей
     * @apiSuccess  {integer}   lastPage                Последняя страница
     * @apiSuccess  {integer}   currentPage             Текущая страница
     * @apiSuccess  {array}     news                    Вопросы
     * @apiSuccess  {integer}   news.id                 ID
     * @apiSuccess  {string}    news.title              Заголовок
     * @apiSuccess  {string}    news.short_description  Описание
     * @apiSuccess  {string}    news.description        Контент
     * @apiSuccess  {string}    news.image              Путь к картинке
     * @apiSuccess  {string}    news.created_at         Дата создания
     *
     * @apiParam  {integer}  [limit]                Кол-ство записей. По умолчанию 15.
     * @apiParam  {integer}  [page]                 Страница
     *
     * @param GetNewsRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function getNews(GetNewsRequest $request): array
    {
        $this->authorize('index', $this->service->getRepository()->getSource());

        return $this->service->getNewsByParams($request->validated());
    }

    /**
     * @api            {get} api/news/{id} Детали новости
     * @apiName        DetailsNews
     * @apiGroup       News
     * @apiDescription Возвращает детали новости
     *
     * @apiSuccess  {integer}   id                 ID
     * @apiSuccess  {string}    title              Заголовок
     * @apiSuccess  {string}    short_description  Описание
     * @apiSuccess  {string}    description        Контент
     * @apiSuccess  {string}    image              Путь к картинке
     * @apiSuccess  {string}    created_at         Дата создания
     *
     * @param int $newsId
     * @return array
     * @throws AuthorizationException
     */
    public function details(int $newsId): array
    {
        $this->authorize('details', $this->service->getRepository()->getSource());

        return $this->service->getNewsDetails($newsId);
    }
}
