<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class OpenAiProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(Client::class, function () {
            return new Client([
                'base_uri' => config('services.openai.base_url'),
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.openai.token'),
                    'content-type' => 'application/json'
                ],
            ]);
        });
    }
}
