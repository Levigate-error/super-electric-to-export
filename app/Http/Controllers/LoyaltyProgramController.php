<?php

namespace App\Http\Controllers;

use App\Services\Loyalty\LoyaltyReceiptService;
use Illuminate\View\View;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserCategoryServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserServiceContract;
use Illuminate\Support\Facades\Auth;
use App\Domain\ServiceContracts\Loyalty\LoyaltyServiceContract;

/**
 * Class LoyaltyProgramController
 * @package App\Http\Controllers
 */
class LoyaltyProgramController extends BaseFrontController
{
    /**
     * @var LoyaltyUserCategoryServiceContract
     */
    private $service;

    /**
     * @var LoyaltyUserServiceContract
     */
    private $loyaltyUserService;

    /**
     * @var LoyaltyReceiptService
     */
    private $loyaltyReceiptService;

    /**
     * LoyaltyProgramController constructor.
     * @param LoyaltyUserCategoryServiceContract $service
     * @param LoyaltyUserServiceContract $loyaltyUserService
     * @param LoyaltyReceiptService $loyaltyReceiptService
     */
    public function __construct(LoyaltyUserCategoryServiceContract $service,
                                LoyaltyUserServiceContract $loyaltyUserService,
                                LoyaltyReceiptService $loyaltyReceiptService,
                                LoyaltyServiceContract $loyaltyService)
    {
        $this->service = $service;
        $this->loyaltyUserService = $loyaltyUserService;
        $this->loyaltyReceiptService = $loyaltyReceiptService;
        $this->loyaltyService = $loyaltyService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $breadcrumbs = [
            [
                'title' => __('loyalty-program.title'),
            ],
        ];

        return view('loyalty-program.index', [
            'breadcrumbs' => $breadcrumbs,
            'userCategories' => $this->service->getUserCategories(),
            'userLoyalties' => $this->loyaltyUserService->getCurrentUserLoyalties(),
            'loyaltyId' => $this->loyaltyService->getLoyaltyProgramId(),
        ]);
    }

    /**
     * @return View
     */
    public function inspiriaIndex(): View
    {
        $breadcrumbs = [
            [
                'title' => __('loyalty-program.inspiria-title'),
            ],
        ];
        $hasPersonalData = Auth::user() 
            ? Auth::user()->personalData()->exists()
            : false;

        return view('loyalty-program.inspiria', [
            'breadcrumbs' => $breadcrumbs,
            'hasPersonalData' => $hasPersonalData,
            'userCategories' => $this->service->getUserCategories(),
            'userLoyalties' => $this->loyaltyUserService->getCurrentUserLoyalties(),
            'userLoyaltyReceipts' => $this->loyaltyReceiptService->getLoyaltyReceiptsByUser(),
            'userLoyaltyReceiptsTotalAmount' => $this->loyaltyReceiptService->getLoyaltyReceiptsTotalAmountByUser()
        ]);
    }
}
