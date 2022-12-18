<?php

namespace Tests\Feature\Traits;

use App\Models\Test\Test;
use App\Models\Test\TestAnswer;
use App\Models\Test\TestQuestion;
use App\Models\Test\TestResult;
use Illuminate\Support\Arr;

/**
 * Trait Testable
 * @package Tests\Feature\Traits
 */
trait Testable
{
    /**
     * Создаем тест с вопросами и ответами.
     *
     * @return array
     */
    protected function prepareFullTestData(): array
    {
        $test = factory(Test::class)->create()->toArray();
        $questions = factory(TestQuestion::class, 3)->create([
            'test_id' => $test['id'],
        ])->toArray();

        foreach ($questions as &$question) {
            $question['answers'] = factory(TestAnswer::class, 3)->create([
                'test_question_id' => $question['id'],
            ])->toArray();
        }

        $results = [];
        $to = -1;
        for ($i=0; $i<10; $i++) {
            $from = $to + 1;
            $to = $from + 10;

            $results[] = factory(TestResult::class)->create([
                'percent_from' => $from,
                'percent_to' => $to,
                'test_id' => $test['id'],
            ])->toArray();
        }

        return [
            'main' => $test,
            'questions' => $questions,
            'results' => $results,
        ];
    }

    /**
     * Подготавлваем данные для передачи в сервис. Подмешиваем не корректные вопросы и ответы.
     * ФОрмируем массив с корректными вопросами и ответами.
     *
     * @param array $test
     * @param array $anotherTest
     * @return array
     */
    protected function prepareParamsAndCorrectResponse(array $test, array $anotherTest = []): array
    {
        $params = [];
        $correctAnswersData = [];

        foreach ($test['questions'] as $question) {
            $answers = [];

            $answer = Arr::random($question['answers']);

            $answers[] = [
                'id' => $answer['id'],
            ];

            $correctAnswersData[] = $answer;

            if (empty($anotherTest) === false) {
                /**
                 * Подмешиваем ответ из другого вопроса и другого теста
                 */
                $answers[] = [
                    'id' => $anotherTest['questions'][1]['answers'][1]['id'],
                ];
            }

            $params['questions'][] = [
                'id' => $question['id'],
                'answers' => $answers,
            ];
        }

        if (empty($anotherTest) === false) {
            /**
             * Подмешиваем вопрос из другого теста, но с ответом от этого вопроса.
             */
            $params['questions'][] = [
                'id' => $anotherTest['questions'][0]['id'],
                'answers' => [
                    [
                        'id' => $anotherTest['questions'][0]['answers'][0]['id'],
                    ]
                ],
            ];

            /**
             * Подмешиваем вопрос из другого теста, но с ответом из другого вопроса.
             */
            $params['questions'][] = [
                'id' => $anotherTest['questions'][1]['id'],
                'answers' => [
                    [
                        'id' => $anotherTest['questions'][0]['answers'][0]['id'],
                    ]
                ],
            ];
        }

        return [
            'params' => $params,
            'correctAnswersData' => $correctAnswersData,
        ];
    }
}
