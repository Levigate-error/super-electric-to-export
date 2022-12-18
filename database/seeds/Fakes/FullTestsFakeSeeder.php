<?php

use Illuminate\Database\Seeder;

/**
 * Class FullTestsFakeSeeder
 */
class FullTestsFakeSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TestsFakeSeeder::class,
            TestQuestionsFakeSeeder::class,
            TestAnswersFakeSeeder::class,
            TestResultsFakeSeeder::class,
        ]);
    }
}
