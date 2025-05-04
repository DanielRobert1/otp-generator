<?php

namespace DanielRobert\Otp\Tests;

use DanielRobert\Otp\OtpGeneratorServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $path = realpath(__DIR__.'/../database/migrations');
        $this->loadMigrationsFrom($path);
        $this->artisan('migrate');
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
