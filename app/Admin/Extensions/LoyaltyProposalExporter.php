<?php

namespace App\Admin\Extensions;

use App\Domain\Dictionaries\Loyalty\LoyaltyUserProposalStatuses;
use App\Models\Loyalty\LoyaltyProposalCancelReason;
use App\Models\Loyalty\LoyaltyUserProposal;
use Illuminate\Support\Carbon;

class LoyaltyProposalExporter extends BaseCsvExporter
{
    protected $fileName = 'loyalty_proposal.csv';

    protected $headings = [
        '№/дата заявки',
        'Фамилия',
        'Имя',
        'Телефон',
        'Email',
        'Город',
        '№ кода',
        '№ кода в базе',
        'Статус',
        'Причина отказа',
    ];

    /**
     * Получение данных для экспорта
     *
     * @param bool $toArray
     *
     * @return array
     */
    public function getData($toArray = true): array
    {
        $data = [];

        foreach (parent::getData(false) as $loyaltyUserProposal) {
            /** @var LoyaltyUserProposal $loyaltyUserProposal */
            $user = $loyaltyUserProposal->loyaltyUserPoint->loyaltyUser->user;

            $statuses = LoyaltyUserProposalStatuses::getToHumanResource();
            $reasons = LoyaltyProposalCancelReason::query()->get()->mapWithKeys(static function ($item) {
                return [$item['id'] => $item['value']];
            })->toArray();

            $data[] = [
                $loyaltyUserProposal->id . ' от ' . Carbon::make($loyaltyUserProposal->created_at)->format('d.m.Y'),
                $user->last_name,
                $user->first_name,
                $user->phone,
                $user->email,
                translate_field($user->city->title),
                $loyaltyUserProposal->code,
                ($loyaltyUserProposal->loyaltyProductCode !== null) ? $loyaltyUserProposal->loyaltyProductCode->code : '',
                $statuses[$loyaltyUserProposal->proposal_status] ?? '',
                $reasons[$loyaltyUserProposal->loyalty_proposal_cancel_reason_id] ?? '',
            ];
        }

        return $data;
    }
}
