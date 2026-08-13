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
            $apiKey = config('openai.api_key') ?? '';
            $organization = config('openai.organization');
            $project = config('openai.project');
            $baseUri = config('openai.base_uri');

            $guzzleOptions = [
                'timeout' => config('openai.request_timeout', 30),
            ];

            if (config('openai.verify_ssl') === false) {
                $guzzleOptions['verify'] = false;
            } elseif (file_exists(storage_path('cacert.pem'))) {
                $guzzleOptions['verify'] = storage_path('cacert.pem');
            }

            $client = OpenAI::factory()
                ->withApiKey($apiKey)
                ->withOrganization($organization)
                ->withHttpClient(new \GuzzleHttp\Client($guzzleOptions));

            if (is_string($project) && !empty($project)) {
                $client->withProject($project);
            }

            if (is_string($baseUri) && !empty($baseUri)) {
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


