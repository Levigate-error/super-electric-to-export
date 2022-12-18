<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Facades\DB;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProposalCancelReasonServiceContract;

/**
 * Class LoyaltyProposalCancelReasonsSeeder
 */
class LoyaltyProposalCancelReasonsSeeder extends Seeder
{
    /**
     * @var LoyaltyProposalCancelReasonServiceContract
     */
    private $service;

    protected const RESOURCE = [
        'МАС-адрес не принят, т.к. это устройство ранее уже было зарегистрировано в программе.',
        'МАС-адрес не принят, т.к. стартовый набор не был приобретен у официального партнера из списка компаний на https://legrand.ru/smart-home',
        'МАС-адрес не принят, т.к. данный Wi-Fi шлюз не был активирован и не зарегистрирован в сети.',
        'Такого МАС-адреса не существует, ознакомьтесь в условиях акции где и как его найти.',
    ];

    /**
     * FakeLoyaltyProposalCancelReasonsSeeder constructor.
     * @param LoyaltyProposalCancelReasonServiceContract $service
     */
    public function __construct(LoyaltyProposalCancelReasonServiceContract $service)
    {
        $this->service = $service;
    }

    public function run()
    {
        DB::table('loyalty_proposal_cancel_reasons')->truncate();

        $this->command->line('<comment>Generate proposal cancel reasons </comment>');
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start(count(static::RESOURCE));

        foreach (static::RESOURCE as $reasonValue) {
            $this->createProposalCancelReason($reasonValue);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }

    /**
     * @param  string  $reasonValue
     * @return array
     */
    protected function createProposalCancelReason(string $reasonValue): array
    {
        $reasonData = [
            'value' => $reasonValue,
        ];

        return $this->service->createProposalCancelReason($reasonData)->resolve();
    }
}
