<?php

namespace App\Repositories\Loyalty;

use App\Models\Loyalty\Loyalty;
use App\Domain\Repositories\Loyalty\LoyaltyRepositoryContract;
use App\Repositories\BaseRepository;
use App\Collections\Loyalty\LoyaltyCollection;

/**
 * Class LoyaltyRepository
 * @package App\Repositories\Loyalty
 */
class LoyaltyRepository extends BaseRepository implements LoyaltyRepositoryContract
{
    /**
     * @var string
     */
    protected $source = Loyalty::class;

    /**
     * @param array $params
     * @return LoyaltyCollection
     */
    public function getLoyaltyList(array $params = []): LoyaltyCollection
    {
        $query = $this->getQueryBuilder();

        if (isset($params['active']) === false) {
            $params['active'] = true;
        }

        return $query->active($params['active'])->get();
    }

    public function getInspiria(): ?Loyalty
    {
        return $this->getQueryBuilder()->where('title', 'Inspiria')->first();
    }
    
    public function getLoyaltyIdByTitle(string $title): ?int
    {
        $query = $this->getQueryBuilder();
        $loyalty = $query->where('title', $title)->first();
        return $loyalty 
            ? $loyalty->id
            : null;
    }
}
