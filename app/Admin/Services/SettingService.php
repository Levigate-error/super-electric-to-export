<?php

namespace App\Admin\Services;

use App\Admin\Helpers\SettingKeySelectorHelper;
use App\Domain\Dictionaries\Setting\SettingDictionary;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Setting;
use Illuminate\Validation\Rule;

/**
 * Class SettingService
 *
 * @package App\Admin\Services
 */
class SettingService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new Setting);

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();

        if (empty(SettingKeySelectorHelper::getDataForSelector())) {
            $grid->disableCreateButton();
        }

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', 'ID')->sortable();

        $grid->column('key', 'Настройка')->display(function () {
            return SettingDictionary::getToHumanResource()[$this->key];
        });

        $grid->column('value', 'Значение');

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new Setting());

        $currentId = request('setting');

        $form->select('key', 'Настройка')
            ->rules([
                'required',
                'string',
                Rule::unique('settings', 'key')->ignore($currentId, 'id'),
            ])
            ->options(SettingKeySelectorHelper::getDataForSelector($currentId !== null ? [$currentId] : []));

        $form->text('value', 'Значение')
            ->help('Множество значений указывается через запятую')
            ->rules('required|string');

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        return $form;
    }

    /**
     * @param int $id
     *
     * @return Show
     */
    public function getDetailPageContent($id): Show
    {
        $show = new Show(Setting::query()->findOrFail($id));

        $show->field('id', 'Id');

        $show->field('key', 'Настройка')->as(function () {
            return SettingDictionary::getToHumanResource()[$this->key];
        });


        $show->field('value', 'Значение');

        $show->field('created_at', 'Дата создания');
        $show->field('updated_at', 'Дата обновления');

        return $show;
    }
}
