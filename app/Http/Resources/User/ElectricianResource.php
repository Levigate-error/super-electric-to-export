<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;
use App\Http\Resources\Loyalty\LoyaltyUserCategoryResource;

/**
 * Ресурс электрика с данными по активной акции
 *
 * Class ElectricianResource
 * @package App\Http\Resources\User
 */
class ElectricianResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $loyaltyCategory = '';
        $loyaltyPoints = 0;
        $certificate = '';

        /**
         * Если юзер принимает участие в программе лояльности, то собираем инфу по ней
         */
        if ($this->loyaltyUsers->isNotEmpty() === true) {
            $activeLoyalty = $this->loyaltyUsers->first();

            $certificate = $activeLoyalty->certificate 
                ? $activeLoyalty->certificate->code
                : '';
            $loyaltyPoints = $activeLoyalty->loyaltyUserPoint->points;
            $loyaltyCategory = LoyaltyUserCategoryResource::make($activeLoyalty->loyaltyUserCategory)->resolve();
        }

        $mainInformation = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'photo' => $this->photoPath,
            'loyalty_certificate' => $certificate,
            'city' => $this->cityName,
            'phone' => $this->phone,
            'email' => $this->email,
            'loyalty_category' => $loyaltyCategory,
            'loyalty_points' => $loyaltyPoints,
        ];

        return array_merge(parent::toArray($request), $mainInformation);
    }
}
