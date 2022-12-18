<?php

namespace App\Admin\Actions\Loyalty;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AddPoints extends BatchAction
{
    /** @var string */
    public $name;

    public function __construct()
    {
        parent::__construct();
        $this->name = __('admin.loyalty.add-points');
    }

    public function handle(Collection $collection, Request $request)
    {

        foreach ($collection as $model) {
            $model->points += $request->points;
            if ($model->points < 0)
            {
                $model->points = 0;
            }
            $model->save();
        }

        return $this->response()->success('Баллы были успешно начислены')->refresh();
    }

    public function form()
    {
        $this->text('points','Количество баллов')->rules([
            'required', 'integer'
        ]);
    }

}