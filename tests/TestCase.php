<?php

namespace DanielRobert\Otp\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use DanielRobert\Otp\OtpGeneratorServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'DanielRobert\\Otp\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $path = realpath(__DIR__.'/../database/migrations');
        var_dump($path, file_exists($path));
        $this->loadMigrationsFrom($path);
    }

    protected function getPackageProviders($app): array
    {
        return [
            OtpGeneratorServiceProvider::class
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
