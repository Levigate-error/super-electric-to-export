<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\AbstractTool;

/**
 * Class ImportUserButton
 *
 * Кнопка перехода на форму импорта.
 *
 * @package App\Admin\Extensions\Tools
 */
class ImportUserButton extends AbstractTool
{
    /**
     * {@inheritDoc\}
     */
    public function render()
    {
        return view('admin.user-import-button', [
            'route' => route('admin.users.form-import')
        ]);
    }
}
