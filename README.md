# Backpack API Log is a database oriented api request and response logger for backpack admin panel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laraflow/backpack-api-log.svg?style=flat-square)](https://packagist.org/packages/laraflow/backpack-api-log)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/laraflow/backpack-api-log/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/laraflow/backpack-api-log/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/laraflow/backpack-api-log/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/laraflow/backpack-api-log/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laraflow/backpack-api-log.svg?style=flat-square)](https://packagist.org/packages/laraflow/backpack-api-log)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require laraflow/backpack-api-log
```

You can run complete installation with:

```bash
php artisan backpack-api-log:install
php artisan migrate
```

Optionally, Install command will publish config and migration. For others, you can publish the config & migration file with:

```bash
php artisan vendor:publish --tag="api-log-config"
php artisan vendor:publish --tag="api-log-migration"
```

This is the contents of the published config file:

```php
return [
    'table' => 'api_logs',
    'model' => \Laraflow\BackpackApiLog\Models\BackpackApiLog::class,
    'route' => 'api-log',
    'enabled' => env('BACKPACK_API_LOG', false),
    'logs' => [
        //which methods should be logged
        'method' => [
            'GET' => 'GET',
            'POST' => 'POST',
            'PUT' => 'PUT',
            'PATCH' => 'PATCH',
            'DELETE' => 'DELETE',
            'OPTION' => 'OPTION',
        ],
        //which api endpoints should be logged
        'host' => [
            //
        ],
        //which api http status code should be logged
        'code' => [
            '200' => '200',
            '400' => '400',
            '500' => '500',
            '404' => '404',
            '422' => '422',
            '419' => '419',
        ],
    ],
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mohammad Hafijul Islam](https://github.com/hafijul233)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
