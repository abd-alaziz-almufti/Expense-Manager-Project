<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use OpenAI;
use OpenAI\Contracts\ClientContract;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ClientContract::class, static function () {
            $apiKey = config('openai.api_key');
            $organization = config('openai.organization');
            $project = config('openai.project');
            $baseUri = config('openai.base_uri');

            $cacertPath = storage_path('cacert.pem');
            $verifyOption = file_exists($cacertPath) ? $cacertPath : false;

            $client = OpenAI::factory()
                ->withApiKey($apiKey)
                ->withOrganization($organization)
                ->withHttpClient(new \GuzzleHttp\Client([
                    'timeout' => config('openai.request_timeout', 30),
                    'verify' => $verifyOption,
                ]));

            if (is_string($project)) {
                $client->withProject($project);
            }

            if (is_string($baseUri)) {
                $client->withBaseUri($baseUri);
            }

            return $client->make();
        });

        $this->app->alias(ClientContract::class, 'openai');
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}


