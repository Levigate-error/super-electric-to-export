<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Facades\Hash;
use App\Domain\Dictionaries\Users\RolesDictionary;
use App\Models\City;
use App\Domain\Dictionaries\Users\SourceDictionary;

/**
 * Class FakeUsersSeeder
 */
class FakeUsersSeeder extends Seeder
{
    /**
     * @var Generator
     */
    private $fakerGenerator;

    /**
     * @var array
     */
    private $roles = [
        RolesDictionary::ELECTRICIAN
    ];

    /**
     * FakeUsersSeeder constructor.
     */
    public function __construct()
    {
        $this->fakerGenerator = Factory::create('ru_RU');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $role) {
            $this->createUser($role);
        }
    }

    /**
     * @param string $role
     * @param int|null $count
     */
    private function createUser(string $role, int $count = null): void
    {
        $userRole = config('roles.models.role')::where('slug', '=', $role)->first();

        if (!$userRole) {
            return;
        }

        $count = $count ?? $this->fakerGenerator->numberBetween(1, 9);
        $users = $this->generateUsers($count, $role);

        foreach ($users as $user) {
            if (config('roles.models.defaultUser')::where('email', '=', $user['email'])->first() === null) {
                $newUser = config('roles.models.defaultUser')::create([
                    'first_name'     => $user['first_name'],
                    'last_name'     => $user['last_name'],
                    'city_id'     => $user['city_id'],
                    'phone'     => $user['phone'],
                    'email'    => $user['email'],
                    'password' => $user['password'],
                    'personal_data_agreement_at' => $user['personal_data_agreement_at'],
                    'email_verified_at' => $user['email_verified_at'],
                    'source'     => SourceDictionary::REGISTRATION,
                ]);

                $newUser->attachRole($userRole);
            }
        }
    }

    /**
     * @param int $count
     * @param string $role
     * @return array
     */
    private function generateUsers(int $count, string $role): array
    {
        $users = [];

        for ($i = 0; $i < $count; $i++) {
            $users[] = [
                'first_name'     => $this->fakerGenerator->firstName,
                'last_name'     => $this->fakerGenerator->lastName,
                'city_id'     => City::query()->inRandomOrder()->first()->id,
                'phone'     => $this->fakerGenerator->phoneNumber,
                'email'    => $role . ($i+1) . '@gmail.com',
                'password' => Hash::make($role . ($i+1)),
                'personal_data_agreement_at' => now(),
                'email_verified_at' => now(),
            ];
        }

        return $users;
    }
}
