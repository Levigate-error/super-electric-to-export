<?php

namespace App\Http\Controllers\Api;

use App\Validators\User\UserProfileCompletenessValidator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Http\Requests\User\UserProfileRequest;
use App\Http\Requests\User\UserPasswordRequest;
use App\Http\Requests\User\UserPersonalDataRequest;
use App\Http\Requests\User\UserProfilePhotoRequest;
use App\Http\Requests\User\UserProfilePublishedRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends BaseApiController
{
    /**
     * @apiDefine   ResponseUserResource
     *
     * @apiSuccess  {integer}   id             Идентификатор
     * @apiSuccess  {string}    first_name     Имя
     * @apiSuccess  {string}    last_name      Фамилия
     * @apiSuccess  {string}    city           Город
     * @apiSuccess  {string}    phone          Телефон
     * @apiSuccess  {string}    email          E-mail
     * @apiSuccess  {string}    photo          Изображение пользователя
     * @apiSuccess  {boolean}   published      Флаг "опубликован"
     *
     * @apiSuccess  {array}     roles              Роли
     * @apiSuccess  {integer}   roles.id           Идентификатор
     * @apiSuccess  {string}    roles.name         Название
     * @apiSuccess  {string}    roles.slug         Слаг
     * @apiSuccess  {string}    roles.description  Описание
     */

    /**
     * @var UserServiceContract
     */
    private $service;

    /**
     * UserController constructor.
     * @param UserServiceContract $service
     */
    public function __construct(UserServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {patch} api/user/profile Обновить профиль
     * @apiName        UserProfileUpdate
     * @apiGroup       User
     * @apiDescription Обновляет профиль юзера
     *
     * @apiParam  {string}   [first_name]   Имя
     * @apiParam  {string}   [last_name]    Фамилия
     * @apiParam  {integer}  city_id      Город
     * @apiParam  {string}   [phone]        Телефон
     * @apiParam  {string}   [email]        E-mail
     *
     * @apiUse    ResponseUserResource
     *
     * @param UserProfileRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function profileUpdate(UserProfileRequest $request): array
    {
        $this->authorize('profile-update', $this->service->getRepository()->getSource());

        return $this->service->updateAndGetCurrentUserProfile($request->validated());
    }

    /**
     * @api            {patch} api/user/password Обновить пароль
     * @apiName        UserPasswordUpdate
     * @apiGroup       User
     * @apiDescription Обновляет пароль юзера
     *
     * @apiParam  {string}   current_password               Текущий пароль
     * @apiParam  {string}   new_password                   Новый пароль
     * @apiParam  {string}   new_password_confirmation      Подтверждение нового пароля
     *
     * @apiUse    ResponseUserResource
     *
     * @param UserPasswordRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function passwordUpdate(UserPasswordRequest $request): array
    {
        $this->authorize('password-update', $this->service->getRepository()->getSource());

        return $this->service->updateCurrentUserPassword($request->validated()['new_password']);
    }

    /**
     * @api            {post} api/user/profile/photo Обновить фото пользователя
     * @apiName        UserProfilePhotoUpdate
     * @apiGroup       User
     * @apiDescription Обновляет фото пользователя
     *
     * @apiParam  {file}     photo        Фото
     *
     * @apiUse    ResponseUserResource
     *
     * @param UserProfilePhotoRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function profilePhotoUpdate(UserProfilePhotoRequest $request): array
    {
        $this->authorize('profile-photo-update', $this->service->getRepository()->getSource());

        return $this->service->updateCurrentUserProfilePhoto($request->validated()['photo']);
    }

    /**
     * @api            {patch} api/user/profile/published Опубликовать профиль
     * @apiName        UserProfilePublishedUpdate
     * @apiGroup       User
     * @apiDescription Устанавливает флаг "опубликован"
     *
     * @apiParam  {boolean}     published          флаг "опубликован"
     * @apiParam  {boolean}     [show_contacts]    флаг "показать контактные данные"
     *
     * @apiUse    ResponseUserResource
     *
     * @apiError  {string}  errors          Ошибки проверки полноты данных юзера
     *
     * @param UserProfilePublishedRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function profilePublishedUpdate(UserProfilePublishedRequest $request)
    {
        $this->authorize('profile-published-update', $this->service->getRepository()->getSource());

        return $this->service->checkAndUpdateCurrentUserProfilePublished($request->validated());
    }

    /**
     * @api            {delete} api/user Удалить пользователя
     * @apiName        UserDelete
     * @apiGroup       User
     * @apiDescription Удаляет текущего пользователя
     *
     * @apiSuccess  {boolean}   result   Результат
     *
     * @return array
     * @throws AuthorizationException
     */
    public function delete(): array
    {
        $this->authorize('delete', $this->service->getRepository()->getSource());

        return [
            'result' => $this->service->deleteCurrentUser(),
        ];
    }

    /**
     * @api            {get} api/user/profile/completeness-check Проверка на полноту данных юзера
     * @apiName        UserProfileCompletenessCheck
     * @apiGroup       User
     * @apiDescription Проверка на полноту данных юзера
     *
     * @apiSuccess  {boolean}   result   Результат
     * @apiSuccess  {string}    errors   Ошибки полноты данных
     *
     * @return array
     * @throws AuthorizationException
     */
    public function profileCompletenessCheck(): array
    {
        $this->authorize('profile-completeness-check', $this->service->getRepository()->getSource());

        $result = [
            'result' => true,
            'errors' => '',
        ];

        $userId = Auth::user()->getAuthIdentifier();
        $validator = new UserProfileCompletenessValidator();

        $checkErrors = $this->service->checkUserDataCompleteness($userId, $validator);
        if ($checkErrors->isNotEmpty() === true) {
            $result = [
                'result' => false,
                'errors' => $checkErrors->first()['errors'],
            ];
        }

        return $result;
    }

    /**
     * @api            {post} api/user/personal-data Сохранение персональных данных пользователя
     * @apiName        StorePersonalData
     * @apiGroup       User
     * @apiDescription Записывает персональные данные пользователя
     * 
     * @apiParam    {string}    passport_series
     * @apiParam    {string}    passport_number
     * @apiParam    {string}    issuer
     * @apiParam    {string}    issuer_code
     * @apiParam    {string}    registration_address
     * @apiParam    {string}    issue_date
     * @apiParam    {string}    taxpayer_number
     * @apiParam    {file}      spread_photo
     * @apiParam    {file}      registration_photo
     * @apiParam    {file}      tax_certificate_photo    
     * 
     * @apiSuccess  {string}   Message   Сообщение
     * 
     * @return JsonResponse
     * @throws AuthorizationException
     */

    public function storePersonalData(UserPersonalDataRequest $request)
    {
        $data = $request->validated();

        $this->service->storePersonalData($data);

        return response()->json(['message' => __('user.personal-data.saved')]);
    }

    /**
     * @api            {get} api/user/auth/check проверять юзер залогинился или нет
     * @apiName        UserCheckAuth
     * @apiGroup       User
     * @apiDescription проверять юзер залогинился или нет
     *
     * @apiSuccess  {boolean}   result   Результат
     *
     * @return array
     * @throws AuthorizationException
     */
    public function checkAuth()
    {
        return response()->json(['code' => 200, 'data' => ['auth' => Auth::check()], 'message' => null]);
    }
}
