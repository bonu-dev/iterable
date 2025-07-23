# PHP Iterable

[![PHPUnit](https://github.com/bonu-dev/iterable/actions/workflows/phpunit.yaml/badge.svg)](https://github.com/bonu-dev/iterable/actions/workflows/phpunit.yaml)

Handle utility methods that simplify iterable operations.

## Requirements

- Minimum version of PHP 8.1

## Installation

```bash
composer require bonu/iterable
```

## Usage

```php
use Bonu\Iterable\Iterables;

$mappedIterable = Iterables::map(
    $myIterable,
    static fn (string $value): string => mb_strtoupper($value),
);
```

## License

This package is licensed under the MIT License.