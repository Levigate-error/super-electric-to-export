<?php

namespace App\Http\Controllers\Api;

use App\Domain\Dictionaries\Loyalty\LoyaltyGiftStatuses;
use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsReviewStatuses;
use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsStatuses;
use App\Models\Loyalty\Gift;
use App\Models\Loyalty\LoyaltyCoupon;
use App\Models\Loyalty\LoyaltyDocument;
use App\Models\Loyalty\LoyaltyGift;
use App\Models\Loyalty\LoyaltyReceipt;
use App\Models\Loyalty\LoyaltyUser;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\Loyalty\LoyaltyServiceContract;
use App\Http\Requests\Loyalty\LoyaltyListRequest;
use App\Http\Requests\Loyalty\LoyaltyManualUploadReceiptRequest;
use App\Http\Requests\Loyalty\LoyaltyUserRegisterRequest;
use App\Http\Requests\Loyalty\LoyaltyRegisterProductCodeRequest;
use App\Http\Requests\Loyalty\LoyaltyUploadReceiptRequest;
use App\Http\Requests\Loyalty\LoyaltyChooseGiftRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



/**
 * Class LoyaltyController
 * @package App\Http\Controllers\Api
 */
class LoyaltyController extends BaseApiController
{
    /**
     * @apiDefine   ResponseBooleanResult
     *
     * @apiSuccess  {array}     data
     * @apiSuccess  {boolean}   data.result                Результат
     */

    /**
     * @apiDefine   ResponseProposals
     *
     * @apiSuccess  {integer}   proposal.id                Идентификатор
     * @apiSuccess  {string}    proposal.status            Статус
     * @apiSuccess  {string}    proposal.status_on_human   Статус на человеческом
     * @apiSuccess  {integer}   proposal.points            Кол-во баллов
     * @apiSuccess  {date}      proposal.created_at        Дата создания
     * @apiSuccess  {object}    proposal.code              Данные о коды товара
     * @apiSuccess  {object}    proposal.cancel_reason     Причина отказа
     */

    /**
     * @var LoyaltyServiceContract
     */
    private $service;

    /**
     * LoyaltyController constructor.
     * @param LoyaltyServiceContract $service
     */
    public function __construct(LoyaltyServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {post} api/loyalty Список акций
     * @apiName        LoyaltyList
     * @apiGroup       Loyalty
     * @apiDescription Возвращает список акций
     *
     * @apiParam  {boolean}  [active]       Флаг активности акции, по умолчанию true
     *
     * @apiSuccess  {array}     loyalties                          Акции
     * @apiSuccess  {integer}   loyalties.id                       Идентификатор
     * @apiSuccess  {string}    loyalties.title                    Заголовок
     * @apiSuccess  {string}    loyalties.started_at               Дата начала
     * @apiSuccess  {string}    loyalties.ended_at                 Дата окончания
     * @apiSuccess  {array}     loyalties.active                   Флаг активности
     *
     * @param LoyaltyListRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function getList(LoyaltyListRequest $request): array
    {
        $this->authorize('get-list', $this->service->getRepository()->getSource());

        return $this->service->getLoyaltyList($request->validated());
    }

    /**
     * @api            {post} api/loyalty/register-user Регистрация пользователя в акции
     * @apiName        LoyaltyRegister
     * @apiGroup       Loyalty
     * @apiDescription Регистрирует пользователя в акции
     *
     * @apiParam  {string}   code           Код сертификата
     * @apiParam  {integer}  loyalty_id     ID акции
     *
     * @apiSuccess  {integer}   id                 ID регистрации
     * @apiSuccess  {string}    status             Статус
     * @apiSuccess  {object}    user               Данные о пользователе
     * @apiSuccess  {object}    loyalty            Данные об акции
     * @apiSuccess  {object}    certificate        Данные о сертификате
     * @apiSuccess  {object}    point              Данные по баллам
     *
     * @param LoyaltyUserRegisterRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function registerUser(LoyaltyUserRegisterRequest $request): array
    {
        $this->authorize('user-register', $this->service->getRepository()->getSource());

        return $this->service->registerUser($request->validated());
    }

    /**
     * @api            {post} api/loyalty/register-product-code Регистрация уникального кода продукта
     * @apiName        LoyaltyRegisterProductCode
     * @apiGroup       Loyalty
     * @apiDescription Регистрирует уникальный код продукта
     *
     * @apiParam  {string}   code           Код сертификата
     * @apiParam  {integer}  loyalty_id     ID акции
     *
     * @apiUse    ResponseProposals
     *
     * @param LoyaltyRegisterProductCodeRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function registerProductCode(LoyaltyRegisterProductCodeRequest $request): array
    {
        $this->authorize('register-product-code', $this->service->getRepository()->getSource());

        return $this->service->registerProductCode($request->validated());
    }

    /**
     * @api            {get} api/loyalty/{id}/proposals Список заявок
     * @apiName        LoyaltyGetProposalsList
     * @apiGroup       Loyalty
     * @apiDescription Возвращает список заявок кодов продуктов пользователя
     *
     * @apiUse    ResponseProposals
     *
     * @param int $loyaltyId
     * @return array
     * @throws AuthorizationException
     */
    public function getProposalsList(int $loyaltyId): array
    {
        $this->authorize('get-proposals-list', $this->service->getRepository()->getSource());

        return $this->service->getCurrentUserProposalsList($loyaltyId);
    }

    /**
     * @api            {post} api/loyalty/upload-receipt Загрузка чека пользователя
     * @apiName        LoyaltyUploadReceiptRequest
     * @apiGroup       Loyalty
     * @apiDescription Загрузка чека пользователя
     *
     * @apiParam  {file}     receipts[]        Чек
     *
     * @apiUse    ResponseProposals
     *
     * @param LoyaltyUploadReceiptRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function uploadReceipt(LoyaltyUploadReceiptRequest $request)
    {
        $request->validated();

        $loyaltyUser = LoyaltyUser::where('user_id', Auth::id())->first();

        $loyaltyReceipt = LoyaltyReceipt::where([
            'loyalty_user_id' => $loyaltyUser->id,
            'coupon_code' => $request->coupon_code,
        ])->first();

        if($loyaltyReceipt != null){
            $path = $request->file('receipts')[0]->store('public/receipts');
            $path = str_replace('public', '', $path);

            LoyaltyReceipt::where([
                'loyalty_user_id' => $loyaltyUser->id,
                'coupon_code' => $request->coupon_code,
            ])->update([
                'coupon' => $path,
                'status_id' => LoyaltyReceiptsStatuses::UNPROCESSED,
                'review_status_id' => LoyaltyReceiptsReviewStatuses::MODERATION
            ]);

            return response()->json(['code' => 200, 'data' => null, 'message' => 'чек принята'], 200);
        }else
            return response()->json(['code' => 400, 'data' => null, 'message' => 'купон использован'], 400);
    }

    /**
     * @api             {post} api/loyalty/manually-upload-receipt Загрузка чека вручную
     * @apiName         LoyaltyManualUploadReceiptRequest
     * @apiGroup        Loyalty
     * @apiDescription  Загрузка чека вручную без фотографии
     *
     *
     * @apiParam    {string}    receipt_datetime    Дата на чеке в формате d.m.y H:i Пример: 01.12.21 15:22
     * @apiParam    {string}    fp                  ФП
     * @apiParam    {string}    fd                  ФД
     * @apiParam    {string}    fn                  ФН
     * @apiParam    {number}    amount              Сумма на чеке
     *
     * @apiUse          ResponseProposals
     *
     * @param LoyaltyManualUploadReceiptRequest $request
     * @return array
     * @throws AuthorizationException
     */

    public function uploadReceiptManually(LoyaltyManualUploadReceiptRequest $request)
    {
        $request->validated();

        $loyaltyUser = LoyaltyUser::where('user_id', Auth::id())->first();

        $loyaltyReceipt = LoyaltyReceipt::where([
            'loyalty_user_id' => $loyaltyUser->id,
            'coupon_code' => $request->coupon_code,
        ])->first();

        $receiptDate = substr_replace($request->receipt_datetime, '20', 6, 0);
        $receiptDate = str_replace('.', '-', $receiptDate);


        if($loyaltyReceipt != null){
            LoyaltyReceipt::where([
                'loyalty_user_id' => $loyaltyUser->id,
                'coupon_code' => $request->coupon_code,
            ])->update([
                'receipt_datetime' => date('Y-m-d H:i:s', strtotime($receiptDate)),
                'fn' => $request->fn,
                'fd' => $request->fd,
                'fp' => $request->fp,
                'amount' => $request->amount,
                'status_id' => LoyaltyReceiptsStatuses::UNPROCESSED,
                'review_status_id' => LoyaltyReceiptsReviewStatuses::MODERATION
            ]);

            return response()->json(['code' => 200, 'data' => null, 'message' => 'чек принята'], 200);
        }else
            return response()->json(['code' => 400, 'data' => null, 'message' => 'купон использован'], 400);
    }


    /**
     * @api             {get} api/loyalty/uploaded-receipts Зарегистрировано чек список
     * @apiName         LoyaltyGetLoyaltyReceiptsByUser
     * @apiGroup        Loyalty
     * @apiDescription  чек список
     *
     * @return array
     * @throws AuthorizationException
     */
    public function getLoyaltyReceiptsByUser()
    {
        return $this->service->getLoyaltyReceiptsByUser();
    }

    /**
     * @api             {get} api/loyalty/total-amount Зарегистрировано чеков на сумму
     * @apiName         LoyaltyGetLoyaltyReceiptsTotalAmountByUser
     * @apiGroup        Loyalty
     * @apiDescription  чеков на сумму
     *
     * @return array
     * @throws AuthorizationException
     */
    public function getLoyaltyReceiptsTotalAmountByUser()
    {
        return ['amount' => $this->totalAmount()];
    }

    /**
     * @api            {get} api/loyalty/gifts Витрина призов
     * @apiName        LoyaltyGiftsRequest
     * @apiGroup       Loyalty
     * @apiDescription Витрина призов
     */
    public function gifts()
    {
        return response()->json([
            'code' => 200,
            'data' => Gift::where('is_active', 1)->orderBy('point', 'ASC')->get(),
            'message' => null
        ]);
    }

    /**
     * @api            {get} api/loyalty/choose-gift Выбрать подарок пользователя
     * @apiName        LoyaltyChooseGiftRequest
     * @apiGroup       Loyalty
     * @apiDescription Загрузка Выбрать подарок
     *
     * @apiParam  {id}     id        подарок
     *
     * @apiUse    ResponseProposals
     *
     * @param Request $request
     * @return array
     * @throws AuthorizationException
     */
    public function chooseGift(Request $request)
    {
        if(Auth::check())
        {
            $gift = Gift::find($request->id);

            if ($gift == null)
                return response()->json(['code' => 422, 'data' => null, 'message' => 'ID поле должно быть заполнено'], 422);

            if($gift->completed == 1)
                return response()->json(['code' => 400, 'data' => null, 'message' => 'Выбранного товара нет в наличии. Пожалуйста, выберите другой продукт'], 400);

            if($this->totalAmount() - $gift->point < 0)
                return response()->json(['code' => 400, 'data' => null, 'message' => 'У вас недостаточно баллов, чтобы получить его'], 400);

            $created = LoyaltyGift::create(['user_id' => Auth::id(), 'gift_id' => $request->id, 'status_id' => 1]);

            return response()->json(['code' => 200, 'data' => $created, 'message' => 'Unauthorized'], 200);
        }else
            return response()->json(['code' => 401, 'data' => null, 'message' => 'Unauthorized'], 401);
    }

    private function totalAmount(){

        $amountChangeTime = "2022-06-06 00:00:00";
        $amount = $this->service->getLoyaltyReceiptsTotalAmountByUserId();

        $gifts = LoyaltyGift::with('gift')->where('user_id', Auth::id())->where('status_id', '!=', LoyaltyGiftStatuses::CANCELED)->get();

        $sum = 0;
        foreach ($gifts as $item){
            if(strtotime($item->created_at) <= strtotime($amountChangeTime))
                $sum += LoyaltyGift::GIFT_POINTS_OLD[$item->gift_id];
            else
                $sum += $item->gift->point;
        }

        return $amount-$sum < 0 ? 0 : $amount-$sum;
    }

    /**
     * @api            {get} api/loyalty/add-coupon Выбрать Код купона
     * @apiName        LoyaltyCheckCouponRequest
     * @apiGroup       Loyalty
     * @apiDescription Код купона
     *
     * @apiParam  {code}     code        Код купона
     *
     * @param Request $request
     * @return array
     * @throws AuthorizationException
     */
    public function addCoupon(Request $request)
    {
        if (!$request->has('code'))
            return response()->json(['code' => 422, 'data' => null, 'message' => 'Code поле должно быть заполнено'], 422);

//        if(Auth::id() == 233){
//            $codes = [83000034,83001273];
//
//            $insertArr = [];
//            foreach($codes as $code){
//                $insertArr[] = ['code' => $code, 'used' => 0];
//            }
//
//            LoyaltyCoupon::insert($insertArr);
//
//            return response()->json(['code' => 444, 'data' => $inserArr, 'message' => 'inserted'], 444);
//        }

        $coupon = LoyaltyCoupon::where('code', $request->input('code'))->first();

        if($coupon != null) {
            if($coupon->used)
                return response()->json(['code' => 400, 'data' => $coupon, 'message' => 'Использованный код купона'], 400);

            $loyaltyUser = LoyaltyUser::where('user_id', Auth::id())->first();

            if($loyaltyUser == null){
                $loyaltyUser = LoyaltyUser::create([
                    'user_id' => Auth::id(),
                    'loyalty_id' => 3, //Inspiria
                    'status' => 'approved',
                    'loyalty_user_category_id' => 2 //Master
                ]);
            }

            LoyaltyReceipt::create([
                'loyalty_user_id' => $loyaltyUser->id,
                'coupon_code' => $coupon->code,
                'status_id' => LoyaltyReceiptsStatuses::UNPROCESSED,
                'review_status_id' => LoyaltyReceiptsReviewStatuses::NEW
            ]);

            $coupon->update(['used' => 1]);

            return response()->json(['code' => 200, 'data' => $coupon, 'message' => 'Код купона можно использовать'], 200);
        }else
            return response()->json(['code' => 404, 'data' => null, 'message' => 'Код купона не найден'], 404);
    }

    /**
     * @api            {get} api/loyalty/get-coupons Купоны пользователя
     * @apiName        LoyaltyCheckCouponRequest
     * @apiGroup       Loyalty
     * @apiDescription Купоны пользователя
     *
     * @apiParam  {page}     page        страница
     * @apiParam  {limit}    limit       ограничение
     *
     * @param Request $request
     * @return array
     * @throws AuthorizationException
     */
    public function userCoupons(Request $request)
    {
        $loyaltyUser = LoyaltyUser::where('user_id', Auth::id())->first();

        $page = $request->input('page') > 0 ? $request->input('page') : 1;
        $limit = $request->input('limit') > 0 ? $request->input('limit') : 5;

        $total = LoyaltyReceipt::whereNotNull('coupon_code')->where('loyalty_user_id', $loyaltyUser->id)->count();
        $coupons = LoyaltyReceipt::whereNotNull('coupon_code')->where('loyalty_user_id', $loyaltyUser->id)->orderBy('id', 'DESC')->skip(($page - 1) * $limit)->take($limit)->get();

        return response()->json(['code' => 200, 'data' => ['coupons' => $coupons, 'total_count' => $total], 'message' => 'зареганные промокоды'], 200);
    }

    /**
     * @api            {get} api/loyalty/documents документы лояльности
     * @apiName        LoyaltyGetDocumentRequest
     * @apiGroup       Loyalty
     * @apiDescription документы лояльности
     *
     * @param Request $request
     * @return array
     * @throws AuthorizationException
     */
    public function documents()
    {
        $document = LoyaltyDocument::orderBy('id', 'DESC')->first();

        return response()->json([
            'code' => 200,
            'data' => [
                'document' => $document != null ? '/storage/'.$document->file : null
            ],
            'message' => 'документы лояльности'
        ], 200);
    }
}
