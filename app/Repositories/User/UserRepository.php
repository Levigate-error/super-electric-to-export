<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Domain\Repositories\User\UserRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\User\UserCollection;

/**
 * Class UserRepository
 * @package App\Repositories\User
 */
class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * @var string
     */
    protected $source = User::class;

    /**
     * @param int $userId
     * @return User|null
     */
    public function getUser(int $userId): ?User
    {
        return $this->getQueryBuilder()->find($userId);
    }

    /**
     * @param array $params
     * @return UserCollection
     */
    public function getUsersByParams(array $params): UserCollection
    {
        $query = $this->getQueryBuilder();

        if (isset($params['role']) === true) {
            $query->whereHas('roles', static function (Builder $builder) use ($params) {
                return $builder->where(['roles.slug' =>  $params['role']]);
            });
            unset($params['role']);
        }

        if (isset($params['published']) === true) {
            $query->published($params['published']);
            unset($params['published']);
        }

        if (isset($params['active_loyalty']) === true) {
            $query->activeLoyalty();
            unset($params['active_loyalty']);
        }

        if (isset($params['publish_ban']) === true) {
            $query->publishBan($params['publish_ban']);
            unset($params['publish_ban']);
        }

        return $query
            ->where($params)
            ->orderBy('id')
            ->get();
    }

    /**
     * @return Builder
     */
    public function getUsersForExport(): Builder
    {
        $query = $this->getQueryBuilder()->select(
            'c.title as city',
            'users.phone',
            'users.email',
            'users.personal_site',
            'users.email_subscription',
            'lu.status as loyalty_status',
            'lup.points as loyalty_points',
            'lc.code as certificate_code'
        )
            ->selectRaw("CONCAT(users.first_name, ' ', users.last_name) as fio")
            ->leftJoin('loyalty_users as lu', 'users.id', '=', 'lu.user_id')
            ->leftJoin('certificates as lc', 'lu.loyalty_certificate_id', '=', 'lc.id')
            ->leftJoin('cities as c', 'c.id', '=', 'users.city_id')
            ->leftJoin('loyalty_user_points as lup', 'lu.id', '=', 'lup.loyalty_user_id');

        return $query;
    }
}
