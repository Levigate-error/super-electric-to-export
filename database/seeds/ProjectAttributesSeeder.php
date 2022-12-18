<?php

use Illuminate\Database\Seeder;
use App\Models\Project\ProjectAttribute;
use App\Models\Project\ProjectAttributeValue;

class ProjectAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resource = [
            [
                'title' => 'Тип помещения',
                'values' => [
                    [
                        'title' => 'Квартира',
                    ],
                    [
                        'title' => 'Дом',
                    ],
                ],
            ],
            [
                'title' => 'Количество комнат',
                'values' => [
                    [
                        'title' => '1',
                    ],
                    [
                        'title' => '2',
                    ],
                    [
                        'title' => '3',
                    ],
                    [
                        'title' => '4',
                    ],
                    [
                        'title' => '5+',
                    ],
                ],
            ],
            [
                'title' => 'Студия',
                'values' => [
                    [
                        'title' => 'Да',
                    ],
                    [
                        'title' => 'Нет',
                    ],
                ],
            ],
            [
                'title' => 'Плита',
                'values' => [
                    [
                        'title' => 'Электрическая',
                    ],
                    [
                        'title' => 'Газовая',
                    ],
                ],
            ],
        ];

        foreach ($resource as $attribute) {
            $projectAttribute = new ProjectAttribute();
            $projectAttribute->fill(['title' => $attribute['title']]);
            setup_translate($projectAttribute);
            $projectAttribute->trySaveModel();

            foreach ($attribute['values'] as $value) {
                $projectAttributeValue = new ProjectAttributeValue();
                $projectAttributeValue->fill([
                    'title' => $value['title'],
                    'project_attribute_id' => $projectAttribute->id,
                ]);
                setup_translate($projectAttributeValue);
                $projectAttributeValue->trySaveModel();
            }
        }
    }
}
