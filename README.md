# OTP Generator and Validator for Laravel Applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danielrobert/otp-generator?style=for-the-badge)](https://packagist.org/packages/danielrobert1otp-generator)
[![Quality Score](https://img.shields.io/scrutinizer/quality/g/danielrobert1/otp-generator/master?style=for-the-badge)](https://scrutinizer-ci.com/g/danielrobert1/otp-generator/)
[![Code Quality](https://img.shields.io/codefactor/grade/github/danielrobert1/otp-generator?style=for-the-badge)](https://www.codefactor.io/repository/github/danielrobert1/otp-generator)
[![Github Workflow Status](https://img.shields.io/github/actions/workflow/status/danielrobert1/otp-generator/run-tests.yml?branch=master&style=for-the-badge)](https://github.com/danielrobert1/otp-generator/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/danielrobert/otp-generator?style=for-the-badge)](https://packagist.org/packages/danielrobert/otp-generator)
[![Licence](https://img.shields.io/packagist/l/danielrobert/otp-generator?style=for-the-badge)](https://packagist.org/packages/danielrobert/otp-generator)



## Installation

You can install the package via composer:

```bash
composer require danielrobert/otp-generator
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="DanielRobert\Otp\OtpServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="DanielRobert\Otp\OtpServiceProvider" --tag="config"
```

## Usage

```php
use DanielRobert\Otp\OTP;
.
.
$otp =  OTP::generate($identifier);
.
$verify = OTP::validate($identifier, $otp->token);
// example response
{
  "status": true
  "message": "OTP is valid"
}

// to get an expiredAt time
$expires = OTP::expiredAt($identifier);

// example response 
{
+"status": true
+"expired_at": Illuminate\Support\Carbon @1611895244^ {
  ....
  #dumpLocale: null
  date: 2021-01-29 04:40:44.0 UTC (+00:00)
}

```

You have control to update the setting at otp-generator.php config file but you control while generating also

## Advance Usage

```php
use DanielRobert\Otp\OTP;
.
.
$otp =  OTP::setValidity(30)  // otp validity time in mins
      ->setLength(4)  // Lenght of the generated otp
      ->setMaximumOtpsAllowed(10) // Number of times allowed to regenerate otps
      ->setOnlyDigits(false)  // generated otp contains mixed characters ex:ad2312
      ->setUseSameToken(true) // if you re-generate OTP, you will get same token
      ->generate($identifier);
.
$verify = OTP::setAllowedAttempts(10) // number of times they can allow to attempt with wrong token
    ->validate($identifier, $otp->token);

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [DanielRobert](https://github.com/danielrobert1)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
