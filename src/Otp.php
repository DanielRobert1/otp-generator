<?php

namespace DanielRobert\Otp;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DanielRobert\Otp\Otp
 */
class Otp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'otp-generator';
    }
}