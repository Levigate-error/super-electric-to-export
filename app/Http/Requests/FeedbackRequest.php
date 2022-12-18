<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FeedbackTypeRule;
use App\Rules\RecaptchaRule;
use Illuminate\Validation\Rule;
use App\Domain\ServiceContracts\FeedbackServiceContract;

/**
 * Class FeedbackRequest
 * @package App\Http\Requests
 */
class FeedbackRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:128',
            'text' => 'required|string|max:1000',
            'name' => 'required|string|max:128',
            'file' => 'file|max:5120|mimes:jpeg,bmp,png,txt,doc,xlsx,xls,ods',
            'type' => ['required', new FeedbackTypeRule()],
            'g-recaptcha-response' => [
                Rule::requiredIf(static function () {
                    /** @var FeedbackServiceContract $feedbackService */
                    $feedbackService = app()->make(FeedbackServiceContract::class);

                    return $feedbackService->isRecaptchaRequired();
                }),
                new RecaptchaRule(),
            ],
        ];
    }
}
