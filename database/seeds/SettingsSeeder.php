<?php

use App\Domain\Dictionaries\Setting\SettingDictionary;
use Illuminate\Database\Seeder;
use App\Models\Setting;

/**
 * Class SettingsSeeder
 */
class SettingsSeeder extends Seeder
{
    private $resource = [
        [
            'key'   => SettingDictionary::FEEDBACK_EMAILS,
            'value' => 'a.zolkin@zebrains.team',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->resource as $setting) {
            $setting = new Setting($setting);
            $setting->trySaveModel();
        }
    }
}
