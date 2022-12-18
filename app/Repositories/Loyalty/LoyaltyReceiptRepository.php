<?php

namespace App\Repositories\Loyalty;

use App\Collections\Loyalty\LoyaltyReceiptsCollection;
use App\Models\Loyalty\LoyaltyReceipt;
use App\Domain\Repositories\Loyalty\LoyaltyReceiptRepositoryContract;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class LoyaltyReceiptRepository
 * @package App\Repositories\Loyalty
 */
class LoyaltyReceiptRepository extends BaseRepository implements LoyaltyReceiptRepositoryContract
{
    /**
     * @var string
     */
    protected $source = LoyaltyReceipt::class;


    /**
     * @param int $userId
     * @param int|null $limit
     * @return LoyaltyReceiptsCollection
     */
    public function getLoyaltyReceiptsByUserId(int $userId, ?int $limit = null): LoyaltyReceiptsCollection
    {
        $query = $this->getLoyaltyReceiptsByUserBaseQuery($userId);

        if (!is_null($limit)) {
            $query = $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * @param int $userId
     * @return float
     */
    public function getLoyaltyReceiptsTotalAmountByUserId(int $userId): float
    {
        $user = User::find($userId);
        $query = $this->getLoyaltyReceiptsByUserBaseQuery($userId);

        return (float) $query->sum('points_already_accured') + $user->points_awarded;
    }

    /**
     * @param int $userId
     * @return Builder
     */
    private function getLoyaltyReceiptsByUserBaseQuery(int $userId): Builder
    {
        return $this->getQueryBuilder()
            ->with('User')
            ->whereHas('User', function($q) use ($userId) {
                $q->where(['users.id' => $userId]);
            })
            ->orderBy('created_at', 'desc');
    }
}
