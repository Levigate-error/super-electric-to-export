<?php

use App\Domain\Dictionaries\Users\RolesDictionary;
use App\Domain\Dictionaries\Users\SourceDictionary;
use Faker\Generator as Faker;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, static function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'city_id' => static function () {
            return factory(City::class)->create()->id;
        },
        'password' => Hash::make('secret'), // secret
        'remember_token' =>  $faker->uuid,
        'personal_data_agreement_at' => now(),
        'show_contacts' => false,
        'published' => false,
        'publish_ban' => false,
        'source' => SourceDictionary::REGISTRATION,
        'email_subscription' => $faker->boolean()
    ];
});

$factory->afterCreating(User::class, static function (User $user, $faker) {
    $role = RolesDictionary::ELECTRICIAN;
    $userRole = config('roles.models.role')::where('slug', '=', $role)->first();
    if (empty($userRole) === true) {
        factory(config('roles.models.role'))->create([
            'slug' => $role,
        ]);
    }

    $user->setRole($role);
});
