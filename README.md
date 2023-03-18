# OTP Generator and Validator for Laravel Applications

[![Unit Tests](https://github.com/DanielRobert1/otp-generator/actions/workflows/run-tests.yml/badge.svg)](https://github.com/DanielRobert1/otp-generator/actions/workflows/run-tests.yml)

[![CodeFactor](https://www.codefactor.io/repository/github/danielrobert1/otp-generator/badge)](https://www.codefactor.io/repository/github/danielrobert1/otp-generator)

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
use DanielRobert\Otp\Otp;
.
.
$otp =  Otp::generate($identifier);
.
$verify = Otp::validate($identifier, $otp->token);
// example response
{
  "status": true
  "message": "OTP is valid"
}

// to get an expiredAt time
$expires = Otp::expiredAt($identifier);

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
use DanielRobert\Otp\Otp;
.
.
$otp =  Otp::setValidity(30)  // otp validity time in mins
      ->setLength(4)  // Lenght of the generated otp
      ->setMaximumOtpsAllowed(10) // Number of times allowed to regenerate otps
      ->setOnlyDigits(false)  // generated otp contains mixed characters ex:ad2312
      ->setUseSameToken(true) // if you re-generate OTP, you will get same token
      ->generate($identifier);
.
$verify = Otp::setAllowedAttempts(10) // number of times they can allow to attempt with wrong token
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
