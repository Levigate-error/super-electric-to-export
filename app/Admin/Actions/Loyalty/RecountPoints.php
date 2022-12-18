<?php

namespace App\Admin\Actions\Loyalty;

use App\Models\Loyalty\LoyaltyUserPoint;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class RecountPoints extends BatchAction
{
    /** @var string */
    public $name;

    public function __construct()
    {
        parent::__construct();
        $this->name = __('admin.loyalty.recount-points');
    }

    public function handle(Collection $collection, Request $request)
    {
        $collection->each(function (LoyaltyUserPoint $model) {
            $sum = $model->loyaltyUserProposals()->sum('accrue_points');
            $model->points = $sum;
            $model->save();
        });
        return $this->response()->success('Баллы были успешно пересчитаны')->refresh();
    }
}