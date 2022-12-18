<?php

namespace App\Console\Commands\Import;

use App\Domain\Dictionaries\Users\SourceDictionary;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Collections\User\UserCollection;
use App\Models\User;
use App\Models\City;
use App\Domain\ServiceContracts\User\UserServiceContract;

/**
 * Class UserImport
 * @package App\Console\Commands\Import
 */
class UserImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:user-import {--file= : File in storage/app/import/}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from file';

    public const HEADER_ROW = 1;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start user import');

        if ($this->option('file') === null) {
            $this->info('Set file name. Like --file=users.xlsx');
            return false;
        }

        $users = $this->getUsersFromFile($this->option('file'));

        $count = $this->importUsers($users);

        $this->info("User import completed. Total users: $count");
    }

    /**
     * @param string $fileName
     * @return UserCollection
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    protected function getUsersFromFile(string $fileName): UserCollection
    {
        $file = storage_path('app' . DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . $fileName);

        $spreadsheet = IOFactory::load($file);

        $sheets = $spreadsheet->getAllSheets();

        $users = new UserCollection();
        $cities = [];

        foreach ($sheets as $sheet) {
            $highestRow = $sheet->getHighestRow('A');
            $startRow = self::HEADER_ROW + 1;

            for ($rowNumber = $startRow; $rowNumber <= $highestRow; $rowNumber++) {
                $userData = [
                    'first_name' => $sheet->getCell("A$rowNumber")->getValue(),
                    'last_name' => $sheet->getCell("B$rowNumber")->getValue(),
                    'phone' => $sheet->getCell("C$rowNumber")->getValue(),
                    'email' => $sheet->getCell("D$rowNumber")->getValue(),
                    'password' => trim($sheet->getCell("E$rowNumber")->getValue()),
                    'city' => $sheet->getCell("F$rowNumber")->getValue(),
                    'personal_site' => $sheet->getCell("G$rowNumber")->getValue(),
                    'email_subscription' => $sheet->getCell("H$rowNumber")->getValue(),
                    'email_verified_at' => now(),
                ];

                if ($this->validateUser($userData) === false) {
                    continue;
                }

                if (isset($cities[$userData['city']]) === false) {
                    $city = City::query()->where('title->ru', '=', $userData['city'])->first();

                    $cities[$userData['city']] = $city;
                }

                if ($cities[$userData['city']] === null) {
                    continue;
                }

                $user = new User($userData);
                $user->city_id = $cities[$userData['city']]->id;

                $users->push($user);
            }
        }

        return $users;
    }

    /**
     * @param array $userData
     * @return bool
     */
    protected function validateUser(array $userData): bool
    {
        $result = true;

        foreach ($userData as $userAttribute) {
            if (empty($userAttribute) === true) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    /**
     * @param UserCollection $users
     * @return int
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function importUsers(UserCollection $users): int
    {
        $userService = app()->make(UserServiceContract::class);
        $userModel = $userService->getRepository()->getSource();

        $existUsers = User::query()->get()->keyBy('email');
        $fileUsers = $users->keyBy('email');

        $newUsers = $fileUsers->diffKeys($existUsers);

        $insertUsers = [];
        foreach ($newUsers as $newUser) {
            $data = $newUser->makeVisible('password')->toArray();
            $data['source'] = SourceDictionary::CLI_IMPORT;
            $userModel::createUser($data);
        }

        User::query()->insert($insertUsers);

        return $newUsers->count();
    }
}
