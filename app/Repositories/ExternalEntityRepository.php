<?php

namespace App\Repositories;

use App\Models\ExternalEntity;
use App\Domain\Repositories\ExternalEntityRepositoryContract;

/**
 * Class ExternalEntityRepository
 * @package App\Repositories
 */
class ExternalEntityRepository extends BaseRepository implements ExternalEntityRepositoryContract
{
    protected $source = ExternalEntity::class;

}
