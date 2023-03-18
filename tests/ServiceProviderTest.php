<?php

namespace DanielRobert\Otp\Tests;

use DanielRobert\Otp\OtpGeneratorServiceProvider;

class ServiceProviderTest extends TestCase
{
    public function test_merges_config(): void
    {
        static::assertSame(
            $this->app->make('files')
                ->getRequire(OtpGeneratorServiceProvider::CONFIG),
            $this->app->make('config')->get('otp-generator')
        );
    }

}