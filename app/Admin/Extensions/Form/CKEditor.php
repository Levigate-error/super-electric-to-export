<?php

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

/**
 * Class CKEditor
 * @package App\Admin\Extensions\Form
 */
class CKEditor extends Field
{
    /**
     * @var array
     */
    public static $js = [
        '/packages/ckeditor/ckeditor.js',
        '/packages/ckeditor/adapters/jquery.js',
    ];

    /**
     * @var string
     */
    protected $view = 'admin.ckeditor';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        $this->script = "$('textarea.{$this->getElementClassString()}').ckeditor();";

        return parent::render();
    }
}
