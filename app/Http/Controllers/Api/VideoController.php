<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Video\VideoSearchRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\Video\VideoServiceContract;
use App\Domain\ServiceContracts\Video\VideoCategoryServiceContract;

/**
 * Class VideoController
 * @package App\Http\Controllers\Api
 */
class VideoController extends BaseApiController
{
    /**
     * @var VideoServiceContract
     */
    private $videoService;

    /**
     * @var VideoCategoryServiceContract
     */
    private $videoCategoryService;

    /**
     * VideoController constructor.
     * @param VideoServiceContract $videoService
     * @param VideoCategoryServiceContract $videoCategoryService
     */
    public function __construct(VideoServiceContract $videoService, VideoCategoryServiceContract $videoCategoryService)
    {
        $this->videoService = $videoService;
        $this->videoCategoryService = $videoCategoryService;
    }

    /**
     * @api            {get} api/video/categories Список категорий видео
     * @apiName        VideoCategoryList
     * @apiGroup       Video
     * @apiDescription Возвращает список категорий видео
     *
     * @apiSuccess  {integer}   id               ID
     * @apiSuccess  {string}    title            Название
     * @apiSuccess  {string}    created_at       Дата создания
     *
     * @return array
     * @throws AuthorizationException
     */
    public function getVideoCategoryList(): array
    {
        $this->authorize('get-list', $this->videoCategoryService->getRepository()->getSource());

        return $this->videoCategoryService->getVideoCategoriesByParams();
    }

    /**
     * @api            {post} api/video/search Поиск видео
     * @apiName        VideoSearch
     * @apiGroup       Video
     * @apiDescription Ищет подходящие видео
     *
     * @apiSuccess  {integer}   total                   Всего записей
     * @apiSuccess  {integer}   lastPage                Последняя страница
     * @apiSuccess  {integer}   currentPage             Текущая страница
     * @apiSuccess  {array}     videos                  Видео
     * @apiSuccess  {integer}   videos.id               ID
     * @apiSuccess  {string}    videos.title            Название
     * @apiSuccess  {string}    videos.video            Ссылка на видео
     * @apiSuccess  {string}    videos.created_at       Дата создания
     * @apiSuccess  {object}    videos.video_category   Категория
     *
     * @apiParam  {integer}  [video_category_id]    ID категории видео
     * @apiParam  {integer}  [limit]                Кол-ство записей. По умолчанию 15.
     * @apiParam  {integer}  [page]                 Страница
     * @apiParam  {string}   [search]               Строка поиска
     *
     * @param VideoSearchRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function searchVideo(VideoSearchRequest $request): array
    {
        $this->authorize('search', $this->videoService->getRepository()->getSource());

        return $this->videoService->getVideosByParams($request->validated());
    }
}
