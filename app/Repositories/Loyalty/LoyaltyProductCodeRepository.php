<?php

namespace App\Repositories\Loyalty;

use App\Models\Loyalty\LoyaltyProductCode;
use App\Domain\Repositories\Loyalty\LoyaltyProductCodeRepositoryContract;
use App\Repositories\BaseRepository;

/**
 * Class LoyaltyProductCodeRepository
 * @package App\Repositories\Loyalty
 */
class LoyaltyProductCodeRepository extends BaseRepository implements LoyaltyProductCodeRepositoryContract
{
    /**
     * @var string
     */
    protected $source = LoyaltyProductCode::class;

    /**
     * @param string $code
     * @return LoyaltyProductCode|null
     */
    public function getProductCodeByCode(string $code): ?LoyaltyProductCode
    {
        $query = $this->getQueryBuilder();

        return $query
            ->whereRaw('LOWER(code) = ?', mb_strtolower($code))
            ->first();
    }
}
