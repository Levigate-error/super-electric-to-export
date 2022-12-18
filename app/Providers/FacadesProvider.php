<?php

namespace App\Providers;

use App\Domain\UtilContracts\HtmlLinkConverterContract;
use Illuminate\Support\ServiceProvider;
use App\Domain\ServiceContracts\SettingServiceContract;

/**
 * Class ServicesProvider
 *
 * @package App\Providers
 */
class FacadesProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $singletons = [
        'Setting'           => SettingServiceContract::class,
        'HtmlLinkConverter' => HtmlLinkConverterContract::class,
    ];
}
