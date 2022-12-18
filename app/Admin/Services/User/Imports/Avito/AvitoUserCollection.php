<?php

namespace App\Admin\Services\User\Imports\Avito;

use App\Admin\Services\User\Imports\BaseCollection;

class AvitoUserCollection extends BaseCollection
{
    /**
     * @inheritDoc
     */
    protected function getElementClassName(): string
    {
        return AvitoUser::class;
    }
}
