<?php

namespace App\Http\Resources;

use App\Http\Resources\Loyalty\LoyaltyUserResource;
use App\Http\Resources\User\UserActivityResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 */
class UserResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $projectActivity = $this->projectsActivities()->get()->last();

        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'city' => $this->cityName,
            'city_full' => $this->city_id !== null ? CityResource::make($this->city)->resolve() : null,
            'phone' => $this->phone,
            'email' => $this->email,
            'photo' => $this->photoPath,
            'published' => $this->published,
            'show_contacts' => $this->show_contacts,
            'roles' => !empty($this->roles) ? RoleResource::collection($this->roles)->resolve() : [],
            'user_loyalties' => ($this->loyaltyUsers !== null) ? LoyaltyUserResource::collection($this->loyaltyUsers->untype())->resolve() : [],
            'activities' => [
                'project' => !empty($projectActivity) ? UserActivityResource::make($projectActivity)->resolve() : [],
            ],
            'publish_ban' => $this->publish_ban,
            'certificates' => CertificateResource::collection($this->certificates),
        ]);
    }
}
