<?php

namespace App\Providers;

use App\Models\Video\Video;
use App\Observers\VideoObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\Project\ProjectProduct;
use App\Models\Project\ProjectSpecification;
use App\Models\Project\ProjectSpecificationProduct;
use App\Models\User;
use App\Models\Project\Project;
use App\Models\Loyalty\LoyaltyUser;
use App\Models\Loyalty\LoyaltyUserProposal;
use App\Models\Loyalty\LoyaltyUserPoint;
use App\Models\Feedback;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Observers\ProjectProductObserver;
use App\Observers\ProjectSpecificationObserver;
use App\Observers\ProjectSpecificationProductsObserver;
use App\Observers\UserObserver;
use App\Observers\ProjectObserver;
use App\Observers\Loyalty\LoyaltyUserObserver;
use App\Observers\Loyalty\LoyaltyUserProposalObserver;
use App\Observers\Loyalty\LoyaltyUserPointObserver;
use App\Observers\FeedbackObserver;
use App\Observers\BannerObserver;
use App\Observers\Product\ProductObserver;
use App\Observers\Product\ProductCategoryObserver;
use App\Observers\Loyalty\LoyaltyReceiptObserver;
use App\Models\Loyalty\LoyaltyReceipt;

/**
 * Class ObserverServiceProvider
 * @package App\Providers
 */
class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ProjectSpecification::observe(ProjectSpecificationObserver::class);
        ProjectSpecificationProduct::observe(ProjectSpecificationProductsObserver::class);
        ProjectProduct::observe(ProjectProductObserver::class);
        User::observe(UserObserver::class);
        Project::observe(ProjectObserver::class);
        LoyaltyUser::observe(LoyaltyUserObserver::class);
        LoyaltyUserProposal::observe(LoyaltyUserProposalObserver::class);
        LoyaltyReceipt::observe(LoyaltyReceiptObserver::class);
        LoyaltyUserPoint::observe(LoyaltyUserPointObserver::class);
        Feedback::observe(FeedbackObserver::class);
        Banner::observe(BannerObserver::class);
        Product::observe(ProductObserver::class);
        ProductCategory::observe(ProductCategoryObserver::class);
        Video::observe(VideoObserver::class);
    }
}
