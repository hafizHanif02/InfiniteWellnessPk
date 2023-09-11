<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class ValidRecaptcha implements Rule
{
    public function passes($attribute, $value)
    {
        $client = new Client([
            'base_uri' => 'https://google.com/recaptcha/api/',
        ]);

        $response = $client->post('siteverify', [
            'query' => [
                'secret' => config('app.recaptcha.secret'),
                'response' => $value,
            ],
        ]);

        return json_decode($response->getBody())->success;
    }

    public function message(): string
    {
        return 'ReCaptcha verification failed.';
    }
}
