<?php

namespace DanielRobert\Otp;

use Illuminate\Support\ServiceProvider;

class OTPGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

     public const DB = __DIR__.'/../database/migrations';
     public const CONFIG = __DIR__.'/../config/otp-generator.php';
     
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::CONFIG => config_path('otp-generator.php'),
            ], 'config');

            $migrationFileName = 'create_otps_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                   self::DB."/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }
        }
    }

    public function register()
    {
        $this->app->alias(OTPGenerator::class, 'otp-generator');
        $this->mergeConfigFrom(self::CONFIG, 'otp-generator');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}