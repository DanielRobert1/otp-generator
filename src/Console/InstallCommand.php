<?php

namespace DanielRobert\Otp\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Otp Generator resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Otp Migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'otp-migration']);

        $this->comment('Publishing Otp Generator Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'otp-config']);

        $this->registerTelescopeServiceProvider();

        $this->info('Otp Generator scaffolding installed successfully.');
    }

    /**
     * Register the Otp service provider in the application configuration file.
     *
     * @return void
     */
    protected function registerTelescopeServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\OtpGeneratorServiceProvider::class')) {
            return;
        }

        $lineEndingCount = [
            "\r\n" => substr_count($appConfig, "\r\n"),
            "\r" => substr_count($appConfig, "\r"),
            "\n" => substr_count($appConfig, "\n"),
        ];

        $eol = array_keys($lineEndingCount, max($lineEndingCount))[0];

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\RouteServiceProvider::class,".$eol,
            "{$namespace}\\Providers\RouteServiceProvider::class,".$eol."        {$namespace}\Providers\OtpGeneratorServiceProvider::class,".$eol,
            $appConfig
        ));

        file_put_contents(app_path('Providers/OtpGeneratorServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/OtpGeneratorServiceProvider.php'))
        ));
    }
}