<?php

use App\Models\Test\TestResult;
use App\Models\Test\Test;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

/**
 * Class TestResultsFakeSeeder
 */
class TestResultsFakeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('test_results')->truncate();

        $this->command->line("<comment>Generate test results</comment>");

        $tests = Test::query()->get();

        foreach ($tests as $test) {
            $this->createEntity($test);
        }

        $this->command->line('');
    }

    /**
     * @param Test $test
     */
    protected function createEntity(Test $test): void
    {
        $to = -1;
        for ($i=0; $i<5; $i++) {
            $from = $to + 1;
            $to = $i*20 + 20;

            factory(TestResult::class)->create([
                'percent_from' => $from,
                'percent_to' => $to,
                'test_id' => $test->id,
            ]);
        }
    }
}
