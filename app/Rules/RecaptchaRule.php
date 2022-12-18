<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;

/**
 * Class RecaptchaRule
 * @package App\Rules
 */
class RecaptchaRule implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = new Client;

        $response = $client->post(config('recaptcha.google-recaptcha-check-url'), [
            'form_params' => [
                'secret' => config('recaptcha.google-recaptcha-secret'),
                'response' => $value
            ]
        ]);

        $body = json_decode((string)$response->getBody());

        return $body->success;
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function message()
    {
        return trans('validation.recaptcha');
    }
}
