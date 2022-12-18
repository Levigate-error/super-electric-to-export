<?php

namespace App\Providers;

use App\Admin\Services\User\Imports\Avito\AvitoUserImportService;
use App\Admin\Services\User\Imports\Avito\AvitoUserParser;
use App\Admin\Services\User\Imports\Avito\AvitoUserSaver;
use App\Domain\ServiceContracts\Imports\Avito\AvitoUserImportServiceContract;
use App\Domain\ServiceContracts\Imports\Avito\AvitoUserParserContract;
use App\Domain\ServiceContracts\Imports\Avito\AvitoUserSaverContract;
use Illuminate\Support\ServiceProvider;
use App\Domain\ServiceContracts\ProductCategoryServiceContract;
use App\Services\ProductCategoryService;
use App\Domain\ServiceContracts\ProductFamilyServiceContract;
use App\Services\ProductFamilyService;
use App\Domain\ServiceContracts\ProductDivisionServiceContract;
use App\Services\ProductDivisionService;
use App\Domain\ServiceContracts\ProductFeatureServiceContract;
use App\Services\ProductFeatureService;
use App\Domain\ServiceContracts\ProductServiceContract;
use App\Services\ProductService;
use App\Domain\ServiceContracts\FavoriteProductServiceContract;
use App\Services\FavoriteProductService;
use App\Domain\ServiceContracts\ProductFeatureTypeDivisionServiceContract;
use App\Services\ProductFeatureTypeDivisionService;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Services\Project\ProjectService;
use App\Domain\ServiceContracts\Project\ProjectAttributeServiceContract;
use App\Services\Project\ProjectAttributeService;
use App\Domain\ServiceContracts\Project\ProjectStatusServiceContract;
use App\Services\Project\ProjectStatusService;
use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;
use App\Services\Project\ProjectSpecificationService;
use App\Domain\ServiceContracts\Project\ProjectSpecificationProductServiceContract;
use App\Services\Project\ProjectSpecificationProductService;
use App\Domain\ServiceContracts\Project\ProjectSpecificationSectionServiceContract;
use App\Services\Project\ProjectSpecificationSectionService;
use App\Domain\ServiceContracts\Project\ProjectProductUpdateContract;
use App\Services\Project\ProjectProductUpdateService;
use App\Domain\ServiceContracts\AnalogueServiceContract;
use App\Services\AnalogueService;
use App\Domain\ServiceContracts\ExternalEntityServiceContract;
use App\Services\ExternalEntityService;
use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Services\User\UserService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyReceiptServiceContract;
use App\Services\Loyalty\LoyaltyReceiptService;
use App\Domain\Repositories\Loyalty\LoyaltyReceiptRepositoryContract;
use App\Repositories\Loyalty\LoyaltyReceiptRepository;
use App\Services\Loyalty\LoyaltyService;
use App\Domain\ServiceContracts\CertificateServiceContract;
use App\Services\CertificateService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserServiceContract;
use App\Services\Loyalty\LoyaltyUserService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProductCodeServiceContract;
use App\Services\Loyalty\LoyaltyProductCodeService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserProposalServiceContract;
use App\Services\Loyalty\LoyaltyUserProposalService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserPointServiceContract;
use App\Services\Loyalty\LoyaltyUserPointService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProposalCancelReasonServiceContract;
use App\Services\Loyalty\LoyaltyProposalCancelReasonService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserCategoryServiceContract;
use App\Services\Loyalty\LoyaltyUserCategoryService;
use App\Domain\ServiceContracts\FeedbackServiceContract;
use App\Services\FeedbackService;
use App\Domain\ServiceContracts\CityServiceContract;
use App\Services\CityService;
use App\Domain\ServiceContracts\BannerServiceContract;
use App\Services\BannerService;
use App\Domain\ServiceContracts\Video\VideoServiceContract;
use App\Services\Video\VideoService;
use App\Domain\ServiceContracts\Video\VideoCategoryServiceContract;
use App\Services\Video\VideoCategoryService;
use App\Domain\ServiceContracts\FaqServiceContract;
use App\Services\FaqService;
use App\Domain\ServiceContracts\NewsServiceContract;
use App\Services\NewsService;
use App\Domain\ServiceContracts\SettingServiceContract;
use App\Services\SettingService;
use App\Domain\ServiceContracts\Log\CreateLogServiceContract;
use App\Services\Log\CreateLogService;
use App\Domain\ServiceContracts\Test\TestServiceContract;
use App\Services\Test\TestService;
use App\Domain\ServiceContracts\Test\TestQuestionServiceContract;
use App\Services\Test\TestQuestionService;
use App\Domain\ServiceContracts\Test\TestUserServiceContract;
use App\Services\Test\TestUserService;

/**
 * Class ServicesProvider
 *
 * @package App\Providers
 */
class ServicesProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $singletons = [
        ProductCategoryServiceContract::class             => ProductCategoryService::class,
        ProductFamilyServiceContract::class               => ProductFamilyService::class,
        ProductDivisionServiceContract::class             => ProductDivisionService::class,
        ProductFeatureServiceContract::class              => ProductFeatureService::class,
        ProductServiceContract::class                     => ProductService::class,
        FavoriteProductServiceContract::class             => FavoriteProductService::class,
        ProductFeatureTypeDivisionServiceContract::class  => ProductFeatureTypeDivisionService::class,
        ProjectServiceContract::class                     => ProjectService::class,
        ProjectAttributeServiceContract::class            => ProjectAttributeService::class,
        ProjectStatusServiceContract::class               => ProjectStatusService::class,
        ProjectSpecificationServiceContract::class        => ProjectSpecificationService::class,
        ProjectSpecificationProductServiceContract::class => ProjectSpecificationProductService::class,
        ProjectSpecificationSectionServiceContract::class => ProjectSpecificationSectionService::class,
        ProjectProductUpdateContract::class               => ProjectProductUpdateService::class,
        AnalogueServiceContract::class                    => AnalogueService::class,
        ExternalEntityServiceContract::class              => ExternalEntityService::class,
        UserServiceContract::class                        => UserService::class,
        CertificateServiceContract::class                 => CertificateService::class,
        LoyaltyServiceContract::class                     => LoyaltyService::class,
        LoyaltyReceiptServiceContract::class              => LoyaltyReceiptService::class,
        LoyaltyReceiptRepositoryContract::class           => LoyaltyReceiptRepository::class,
        LoyaltyUserServiceContract::class                 => LoyaltyUserService::class,
        LoyaltyProductCodeServiceContract::class          => LoyaltyProductCodeService::class,
        LoyaltyUserProposalServiceContract::class         => LoyaltyUserProposalService::class,
        LoyaltyUserPointServiceContract::class            => LoyaltyUserPointService::class,
        LoyaltyProposalCancelReasonServiceContract::class => LoyaltyProposalCancelReasonService::class,
        LoyaltyUserCategoryServiceContract::class         => LoyaltyUserCategoryService::class,
        FeedbackServiceContract::class                    => FeedbackService::class,
        CityServiceContract::class                        => CityService::class,
        BannerServiceContract::class                      => BannerService::class,
        VideoServiceContract::class                       => VideoService::class,
        VideoCategoryServiceContract::class               => VideoCategoryService::class,
        FaqServiceContract::class                         => FaqService::class,
        NewsServiceContract::class                        => NewsService::class,
        SettingServiceContract::class                     => SettingService::class,
        CreateLogServiceContract::class                   => CreateLogService::class,
        TestServiceContract::class                        => TestService::class,
        TestQuestionServiceContract::class                => TestQuestionService::class,
        TestUserServiceContract::class                    => TestUserService::class,
        AvitoUserParserContract::class                    => AvitoUserParser::class,
        AvitoUserSaverContract::class                     => AvitoUserSaver::class,
        AvitoUserImportServiceContract::class             => AvitoUserImportService::class,
    ];
}
