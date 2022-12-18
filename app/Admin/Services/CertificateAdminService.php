<?php

namespace App\Admin\Services;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use App\Admin\Services\BaseService;
use App\Domain\ServiceContracts\CertificateServiceContract;
use App\Models\Certificate;

/**
 * Class CertificateAdminService
 * @package App\Admin\Services
 */
class CertificateAdminService extends BaseService
{
    /**
     * @var CertificateServiceContract
     */
    private $service;

    /**
     * CertificateAdminService constructor.
     * @param CertificateServiceContract $service
     */
    public function __construct(CertificateServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new Certificate());

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->actions(function (Actions $actions) {
            $actions->disableView();
        });

        $grid->model()->orderBy('id', 'asc');

        $grid->id('ID')->sortable();
        $grid->code('Код');
        $grid->active('Активно')->display(function () {
            return ($this->active === true) ? 'Не активирован' : 'Активирован';
        });

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new Certificate());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        $form->disableEditingCheck();
        $form->disableViewCheck();

        $form->display('id', 'ID');
        $form->text('code', 'Код');
        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        return $form;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function checkEditPossibility(int $id): bool
    {
        $productCode = $this->service->getRepository()->getById($id);

        return $productCode->active !== false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function checkDeletePossibility(int $id): bool
    {
        return $this->checkEditPossibility($id);
    }

    /**
     * @inheritDoc
     */
    public function getDetailPageContent(int $id)
    {
        // TODO: Implement getDetailPageContent() method.
    }
}
