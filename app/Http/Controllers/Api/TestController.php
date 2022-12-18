<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\Test\TestServiceContract;
use App\Http\Requests\Test\RegisterTestRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class TestController
 * @package App\Http\Controllers\Api
 */
class TestController extends BaseApiController
{
    /**
     * @apiDefine   ResponseTestResource
     *
     * @apiSuccess  {integer}   id                                ID
     * @apiSuccess  {string}    title                             Заголовок
     * @apiSuccess  {string}    description                       Контент
     * @apiSuccess  {string}    image                             Путь к картинке
     * @apiSuccess  {string}    created_at                        Дата создания
     * @apiSuccess  {array}     questions                         Вопросы
     * @apiSuccess  {integer}   questions.id                      ID
     * @apiSuccess  {string}    questions.question                Вопрос
     * @apiSuccess  {string}    questions.image                   Путь к картинке
     * @apiSuccess  {string}    questions.created_at              Дата создания
     * @apiSuccess  {array}     questions.answers                 Ответы
     * @apiSuccess  {integer}   questions.answers.id              ID
     * @apiSuccess  {array}     questions.answers.answer          Ответ
     * @apiSuccess  {boolean}   questions.answers.is_correct      Правильный ли
     * @apiSuccess  {array}     questions.answers.description     Описание
     * @apiSuccess  {integer}   questions.answers.points          Баллы
     * @apiSuccess  {array}     questions.answers.created_at      Дата создания
     */

    /**
     * @var TestServiceContract
     */
    private $service;


    /**
     * TestController constructor.
     * @param TestServiceContract $service
     */
    public function __construct(TestServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {get} api/tests Список тестов
     * @apiName        GetTests
     * @apiGroup       Tests
     * @apiDescription Возвращает список тестов
     *
     * @apiUse    ResponseTestResource
     *
     * @return array
     * @throws AuthorizationException
     */
    public function getTests(): array
    {
        $this->authorize('index', $this->service->getRepository()->getSource());

        return $this->service->getTests();
    }

    /**
     * @api            {get} api/tests/{id} Детали теста
     * @apiName        DetailsTest
     * @apiGroup       Tests
     * @apiDescription Возвращает детали теста
     *
     * @apiUse    ResponseTestResource
     *
     * @param int $testId
     * @return array
     * @throws AuthorizationException
     */
    public function getDetails(int $testId): array
    {
        $this->authorize('show', $this->service->getRepository()->getSource());

        return $this->service->getTest($testId);
    }

    /**
     * @api            {post} api/tests/{id} Регистрация прохождения теста
     * @apiName        RegisterTest
     * @apiGroup       Tests
     * @apiDescription Возвращает результат прохождения теста
     *
     * @apiParam  {array}    questions                Вопросы
     * @apiParam  {integer}  questions.id             ID вопроса
     * @apiParam  {array}    questions.answers        Ответы
     * @apiParam  {integer}  questions.answers.id     ID ответа
     *
     * @apiSuccess  {object}    test                              Ресура теста
     * @apiSuccess  {object}    result                            Ресура результата
     * @apiSuccess  {integer}   result.id                         ID
     * @apiSuccess  {string}    result.title                      Заголовок
     * @apiSuccess  {string}    result.description                Описание
     * @apiSuccess  {integer}   result.percent_from               Процент От
     * @apiSuccess  {integer}   result.percent_to                 Процент До
     * @apiSuccess  {string}    result.image                      Картинка
     * @apiSuccess  {string}    result.created_at                 Дата создания
     * @apiSuccess  {string}    points_result                     Инфа по набраным очкаи
     *
     * @param int $testId
     * @param RegisterTestRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function registerTest(int $testId, RegisterTestRequest $request): array
    {
        $this->authorize('register', $this->service->getRepository()->getSource());

        $userId = Auth::user()->getAuthIdentifier();

        $this->service->registerTest($testId, $userId, $request->all());

        return $this->service->getTestResults($testId, $userId);
    }
}
