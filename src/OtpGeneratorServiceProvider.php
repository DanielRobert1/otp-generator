<?php

namespace DanielRobert\Otp;

use DanielRobert\Otp\Contracts\ClearableRepository;
use DanielRobert\Otp\Contracts\PrunableRepository;
use DanielRobert\Otp\Storage\DatabaseOtpsRepository;
use Illuminate\Support\ServiceProvider;

class OtpGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

     public const DB = __DIR__.'/../database/migrations';
     public const CONFIG = __DIR__.'/../config/otp-generator.php';

    public function boot(): void
    {
        $this->registerCommands();
        $this->registerPublishing();
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::DB => database_path('migrations'),
            ], 'otp-migrations');

            $this->publishes([
                self::CONFIG => config_path('otp-generator.php'),
            ], 'otp-config');
        }
    }

    /**
     * Register the package's commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\PublishCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG, 'otp-generator'
        );
        $this->app->alias(OtpGenerator::class, 'otp-generator');
    }

    /**
     * Register the package database storage driver.
     *
     * @return void
     */
    protected function registerDatabaseDriver()
    {
        $this->app->singleton(
            ClearableRepository::class, DatabaseOtpsRepository::class
        );

        $this->app->singleton(
            PrunableRepository::class, DatabaseOtpsRepository::class
        );

        $this->app->when(DatabaseOtpsRepository::class)
            ->needs('$connection')
            ->give(config('otp-generator.storage.database.connection'));
    }
}
