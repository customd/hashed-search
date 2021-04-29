<?php

namespace CustomD\HashedSearch;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Config;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected const CONFIG_PATH = __DIR__ . '/../config/hashed-search.php';
    protected const MIGRATIONS_PATH = __DIR__ . '/../database/migrations/hashed_search.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('hashed-search.php'),
        ], 'hashed-search-config');

        $this->publishes([
            self::MIGRATIONS_PATH => base_path('database/migrations/' . date('Y_m_d_His') . '_hashed_search.php'),
        ], 'hashed-search-migration');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'hashed-search'
        );

        $this->app->bind('hashed-search', function (Application $app) {
            return new HashedSearch($app['config']['hashed-search']);
        });
    }
}
