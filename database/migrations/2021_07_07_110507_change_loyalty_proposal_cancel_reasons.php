<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeLoyaltyProposalCancelReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('loyalty_proposal_cancel_reasons')
            ->where('value', 'МАС-адрес не принят, т.к. это устройство ранее уже было зарегистрировано в программе.')
            ->update(['value' => 'Серийный номер не принят, т.к. это устройство ранее уже было зарегистрировано в программе.']);
        DB::table('loyalty_proposal_cancel_reasons')
            ->where('value', 'МАС-адрес не принят, т.к. стартовый набор не был приобретен у официального партнера из списка компаний на https://legrand.ru/smart-home')
            ->update(['value' => 'Серийный номер не принят, т.к. стартовый набор не был приобретен у официального партнера из списка компаний на https://legrand.ru/smart-home']);
        DB::table('loyalty_proposal_cancel_reasons')
            ->where('value', 'МАС-адрес не принят, т.к. данный Wi-Fi шлюз не был активирован и не зарегистрирован в сети.')
            ->update(['value' => 'Серийный номер не принят, т.к. данный Wi-Fi шлюз не был активирован и не зарегистрирован в сети.']);
        DB::table('loyalty_proposal_cancel_reasons')
            ->where('value', 'Такого МАС-адреса не существует, ознакомьтесь в условиях акции где и как его найти.')
            ->update(['value' => 'Такого серийного номера не существует, ознакомьтесь в условиях акции где и как его найти.']);
        DB::table('loyalty_proposal_cancel_reasons')->insert([
            'value' => 'Серийный номер не принят, т.к. устройство не является Wi-Fi шлюзом',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('loyalty_proposal_cancel_reasons')
            ->where('value', 'Серийный номер не принят, т.к. это устройство ранее уже было зарегистрировано в программе.')
            ->update(['value' => 'МАС-адрес не принят, т.к. это устройство ранее уже было зарегистрировано в программе.']);
        DB::table('loyalty_proposal_cancel_reasons')
            ->where('value', 'Серийный номер не принят, т.к. стартовый набор не был приобретен у официального партнера из списка компаний на https://legrand.ru/smart-home')
            ->update(['value' => 'МАС-адрес не принят, т.к. стартовый набор не был приобретен у официального партнера из списка компаний на https://legrand.ru/smart-home']);
        DB::table('loyalty_proposal_cancel_reasons')
            ->where('value', 'Серийный номер не принят, т.к. данный Wi-Fi шлюз не был активирован и не зарегистрирован в сети.')
            ->update(['value' => 'МАС-адрес не принят, т.к. данный Wi-Fi шлюз не был активирован и не зарегистрирован в сети.']);
        DB::table('loyalty_proposal_cancel_reasons')
            ->where('value', 'Такого серийного номера не существует, ознакомьтесь в условиях акции где и как его найти.')
            ->update(['value' => 'Такого МАС-адреса не существует, ознакомьтесь в условиях акции где и как его найти.']);
        DB::table('loyalty_proposal_cancel_reasons')->where('value', 'Серийный номер не принят, т.к. устройство не является Wi-Fi шлюзом')->delete();
    }
}
