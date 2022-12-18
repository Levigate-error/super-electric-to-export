<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\ProductCategoryRepository;
use App\Repositories\ProductCategoryEloquentRepository;
use App\Domain\Repositories\ProductFamilyRepository;
use App\Repositories\ProductFamilyEloquentRepository;
use App\Domain\Repositories\ProductDivisionRepository;
use App\Repositories\ProductDivisionEloquentRepository;
use App\Domain\Repositories\ProductFeatureRepository;
use App\Repositories\ProductFeatureEloquentRepository;
use App\Domain\Repositories\ProductRepository;
use App\Repositories\ProductEloquentRepository;
use App\Domain\Repositories\FavoriteProductRepository;
use App\Repositories\FavoriteProductEloquentRepository;
use App\Domain\Repositories\ProductFeatureTypeDivisionRepository;
use App\Repositories\ProductFeatureTypeDivisionEloquentRepository;
use App\Domain\Repositories\Project\ProjectRepository;
use App\Repositories\Project\ProjectEloquentRepository;
use App\Domain\Repositories\Project\ProjectAttributeRepository;
use App\Repositories\Project\ProjectAttributeEloquentRepository;
use App\Domain\Repositories\Project\ProjectStatusRepository;
use App\Repositories\Project\ProjectStatusEloquentRepository;
use App\Domain\Repositories\Project\ProjectSpecificationRepository;
use App\Repositories\Project\ProjectSpecificationEloquentRepository;
use App\Domain\Repositories\Project\ProjectSpecificationProductRepository;
use App\Repositories\Project\ProjectSpecificationProductEloquentRepository;
use App\Domain\Repositories\Project\ProjectSpecificationSectionRepository;
use App\Repositories\Project\ProjectSpecificationSectionEloquentRepository;
use App\Domain\Repositories\Project\ProjectProductUpdateRepository;
use App\Repositories\Project\ProjectProductUpdateEloquentRepository;
use App\Domain\Repositories\AnalogueRepository;
use App\Repositories\AnalogueEloquentRepository;
use App\Domain\Repositories\ExternalEntityRepositoryContract;
use App\Repositories\ExternalEntityRepository;
use App\Domain\Repositories\User\UserRepositoryContract;
use App\Repositories\User\UserRepository;
use App\Domain\Repositories\Loyalty\LoyaltyRepositoryContract;
use App\Repositories\Loyalty\LoyaltyRepository;
use App\Domain\Repositories\CertificateRepositoryContract;
use App\Repositories\CertificateRepository;
use App\Domain\Repositories\Loyalty\LoyaltyUserRepositoryContract;
use App\Repositories\Loyalty\LoyaltyUserRepository;
use App\Domain\Repositories\Loyalty\LoyaltyProductCodeRepositoryContract;
use App\Repositories\Loyalty\LoyaltyProductCodeRepository;
use App\Domain\Repositories\Loyalty\LoyaltyUserProposalRepositoryContract;
use App\Repositories\Loyalty\LoyaltyUserProposalRepository;
use App\Domain\Repositories\Loyalty\LoyaltyUserPointRepositoryContract;
use App\Repositories\Loyalty\LoyaltyUserPointRepository;
use App\Domain\Repositories\Loyalty\LoyaltyProposalCancelReasonRepositoryContract;
use App\Repositories\Loyalty\LoyaltyProposalCancelReasonRepository;
use App\Domain\Repositories\Loyalty\LoyaltyUserCategoryRepositoryContract;
use App\Repositories\Loyalty\LoyaltyUserCategoryRepository;
use App\Domain\Repositories\FeedbackRepositoryContract;
use App\Repositories\FeedbackRepository;
use App\Domain\Repositories\CityRepositoryContract;
use App\Repositories\CityRepository;
use App\Domain\Repositories\BannerRepositoryContract;
use App\Repositories\BannerRepository;
use App\Domain\Repositories\Video\VideoRepositoryContract;
use App\Repositories\Video\VideoRepository;
use App\Domain\Repositories\Video\VideoCategoryRepositoryContract;
use App\Repositories\Video\VideoCategoryRepository;
use App\Domain\Repositories\FaqRepositoryContract;
use App\Repositories\FaqRepository;
use App\Domain\Repositories\NewsRepositoryContract;
use App\Repositories\NewsRepository;
use App\Domain\Repositories\SettingRepositoryContract;
use App\Repositories\SettingRepository;
use App\Domain\Repositories\Log\CreateLogRepositoryContract;
use App\Repositories\Log\CreateLogRepository;
use App\Domain\Repositories\Test\TestRepositoryContract;
use App\Repositories\Test\TestRepository;
use App\Domain\Repositories\Test\TestResultRepositoryContract;
use App\Repositories\Test\TestResultRepository;
use App\Domain\Repositories\Test\TestQuestionRepositoryContract;
use App\Repositories\Test\TestQuestionRepository;
use App\Domain\Repositories\Test\TestAnswerRepositoryContract;
use App\Repositories\Test\TestAnswerRepository;
use App\Domain\Repositories\Test\TestUserRepositoryContract;
use App\Repositories\Test\TestUserRepository;
use App\Domain\Repositories\Test\TestUserTestAnswerRepositoryContract;
use App\Repositories\Test\TestUserTestAnswerRepository;

/**
 * Class RepositoriesProvider
 * @package App\Providers
 */
class RepositoriesProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $singletons = [
        ProductCategoryRepository::class => ProductCategoryEloquentRepository::class,
        ProductFamilyRepository::class => ProductFamilyEloquentRepository::class,
        ProductDivisionRepository::class => ProductDivisionEloquentRepository::class,
        ProductFeatureRepository::class => ProductFeatureEloquentRepository::class,
        ProductRepository::class => ProductEloquentRepository::class,
        FavoriteProductRepository::class => FavoriteProductEloquentRepository::class,
        ProductFeatureTypeDivisionRepository::class => ProductFeatureTypeDivisionEloquentRepository::class,
        ProjectRepository::class => ProjectEloquentRepository::class,
        ProjectAttributeRepository::class => ProjectAttributeEloquentRepository::class,
        ProjectStatusRepository::class => ProjectStatusEloquentRepository::class,
        ProjectSpecificationRepository::class => ProjectSpecificationEloquentRepository::class,
        ProjectSpecificationProductRepository::class => ProjectSpecificationProductEloquentRepository::class,
        ProjectSpecificationSectionRepository::class => ProjectSpecificationSectionEloquentRepository::class,
        ProjectProductUpdateRepository::class => ProjectProductUpdateEloquentRepository::class,
        AnalogueRepository::class => AnalogueEloquentRepository::class,
        ExternalEntityRepositoryContract::class => ExternalEntityRepository::class,
        UserRepositoryContract::class => UserRepository::class,
        CertificateRepositoryContract::class => CertificateRepository::class,
        LoyaltyRepositoryContract::class => LoyaltyRepository::class,
        LoyaltyUserRepositoryContract::class => LoyaltyUserRepository::class,
        LoyaltyProductCodeRepositoryContract::class => LoyaltyProductCodeRepository::class,
        LoyaltyUserProposalRepositoryContract::class => LoyaltyUserProposalRepository::class,
        LoyaltyUserPointRepositoryContract::class => LoyaltyUserPointRepository::class,
        LoyaltyProposalCancelReasonRepositoryContract::class => LoyaltyProposalCancelReasonRepository::class,
        LoyaltyUserCategoryRepositoryContract::class => LoyaltyUserCategoryRepository::class,
        FeedbackRepositoryContract::class => FeedbackRepository::class,
        CityRepositoryContract::class => CityRepository::class,
        BannerRepositoryContract::class => BannerRepository::class,
        VideoRepositoryContract::class => VideoRepository::class,
        VideoCategoryRepositoryContract::class => VideoCategoryRepository::class,
        FaqRepositoryContract::class => FaqRepository::class,
        NewsRepositoryContract::class => NewsRepository::class,
        SettingRepositoryContract::class => SettingRepository::class,
        CreateLogRepositoryContract::class => CreateLogRepository::class,
        TestRepositoryContract::class => TestRepository::class,
        TestResultRepositoryContract::class => TestResultRepository::class,
        TestQuestionRepositoryContract::class => TestQuestionRepository::class,
        TestAnswerRepositoryContract::class => TestAnswerRepository::class,
        TestUserRepositoryContract::class => TestUserRepository::class,
        TestUserTestAnswerRepositoryContract::class => TestUserTestAnswerRepository::class,
    ];
}
