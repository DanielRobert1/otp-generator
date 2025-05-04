# Otp Generator and Validator for Laravel Applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danielrobert/otp-generator?style=for-the-badge)](https://packagist.org/packages/danielrobert1otp-generator)
[![Quality Score](https://img.shields.io/scrutinizer/quality/g/danielrobert1/otp-generator/master?style=for-the-badge)](https://scrutinizer-ci.com/g/danielrobert1/otp-generator/)
[![Code Quality](https://img.shields.io/codefactor/grade/github/danielrobert1/otp-generator?style=for-the-badge)](https://www.codefactor.io/repository/github/danielrobert1/otp-generator)
[![Github Workflow Status](https://img.shields.io/github/actions/workflow/status/danielrobert1/otp-generator/run-tests.yml?branch=master&style=for-the-badge)](https://github.com/danielrobert1/otp-generator/actions/workflows/run-tests.yml)
<!-- [![Total Downloads](https://img.shields.io/packagist/dt/danielrobert/otp-generator?style=for-the-badge)](https://packagist.org/packages/danielrobert/otp-generator) -->
[![Licence](https://img.shields.io/packagist/l/danielrobert/otp-generator?style=for-the-badge)](https://packagist.org/packages/danielrobert/otp-generator)



## Installation

You may use the Composer package manager to install Otp Generator into your Laravel project:

```bash
composer require danielrobert/otp-generator
```

After installing the otp-generator, you need to publish its configuration and migration files. The migration files will be copied to your application's database/migrations directory, but they are not run automatically. You must run the migrate command yourself to create the necessary tables:

```bash
php artisan vendor:publish --provider="DanielRobert\Otp\OtpGeneratorServiceProvider" --tag=otp-migrations
php artisan vendor:publish --provider="DanielRobert\Otp\OtpGeneratorServiceProvider" --tag=otp-config
php artisan migrate
```


## Configuration

After publishing Otp Generator's configs, its primary configuration file will be located at config/otp-generator.php. This configuration file allows you to configure your otps. Each configuration option includes a description of its purpose, so be sure to thoroughly explore this file.


## Data Pruning

Data Pruning
Without pruning, the otps table can accumulate records very quickly. To mitigate this, you can schedule the otp:prune Artisan command to run daily:

```php
$schedule->command('otp:prune')->daily();
```

By default, all expired entries or entries older than 30 minutes as configured in the config/otp-generator.php will be pruned. You may use the minutes option when calling the command to determine how long to retain data. For example, the following command will delete all records created over 60 minutes ago:

```php
$schedule->command('otp:prune --minutes=60')->daily();
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
  "message": "Otp is valid"
}

// to get an expiredAt time
$expires = Otp::expiredAt($identifier);

// example response 
+"status": true
+"expired_at": Illuminate\Support\Carbon @1611895244^ {
  ....
  #dumpLocale: null
  date: 2021-01-29 04:40:44.0 UTC (+00:00)
}

```

## Advance Usage

In addition to configuring otps from the otp-generator.php config file you can also configure it directly

```php
use DanielRobert\Otp\Otp;
.
.
$otp =  Otp::setValidity(30)  // otp validity time in mins
      ->setLength(4)  // Lenght of the generated otp
      ->setMaximumOtpsAllowed(10) // Number of times allowed to regenerate otps
      ->setOnlyDigits(false)  // generated otp contains mixed characters ex:ad2312
      ->setUseSameToken(true) // if you re-generate Otp, you will get same token
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

-   [Aigbe Daniel Robert](https://github.com/danielrobert1)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
