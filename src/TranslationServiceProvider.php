<?php

namespace Manifesthq\Translation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Manifesthq\Translation\Http\Middleware\HandleTranslation;

class TranslationServiceProvider extends ServiceProvider
{
  
    /**
     * Bootstrap the application services.
     * Updated Package Version to v1.0.0.2
     */
    public function boot(Router $router)
    {
      
        //Globally Register Middleware
        $router->pushMiddlewareToGroup('web', HandleTranslation::class);

        /*
         * Optional methods to load your package assets
         */


        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'translation');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'translation');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if ($this->app->runningInConsole()) {

            // Publish Configuration File

            $this->publishes([
                __DIR__.'/config/config.php' => config_path('translation.php'),
            ], 'translation-config');


            // Publish Migrations
            $this->publishes([

                __DIR__.'/database/migrations/create_manifesthq_trans_config_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_manifesthq_trans_config_table.php'), 

            ], 'migrations');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/translation'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/translation'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/translation'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'translation');


        // Register the main class to use with the facade
        $this->app->singleton('translation', function () {
            return new Translation;
        });

        //Register Helper 

        require_once __DIR__.'/helpers.php';

    }
}
