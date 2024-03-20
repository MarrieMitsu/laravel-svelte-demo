<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       	if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

        // Recursively transform nested array into Collection
        Collection::macro('recursive', function (): Collection {
            return $this->map(function ($value) {
                if (is_array($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });

    }
}
