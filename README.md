# PHP Iterable

[![PHPUnit](https://github.com/bonu-dev/iterable/actions/workflows/phpunit.yaml/badge.svg?branch=main)](https://github.com/bonu-dev/iterable/actions/workflows/phpunit.yaml)
[![Latest Stable Version](https://poser.pugx.org/bonu/iterable/v)](https://packagist.org/packages/bonu/iterable)
[![License](https://poser.pugx.org/bonu/iterable/license)](https://packagist.org/packages/bonu/iterable)
[![PHP Version](https://img.shields.io/packagist/php-v/bonu/iterable.svg)](https://packagist.org/packages/bonu/iterable)

Handy utility methods that simplify iterable operations.

## Requirements

- Minimum version of PHP 8.2

## Installation

```bash
composer require bonu/iterable
```

## Usage

```php
use Bonu\Iterable\Iterables;

// ['FOO', 'BAR']
Iterables::map(
    ['foo', 'bar'],
    static fn (string $value): string => mb_strtoupper($value),
);

// ['FOO' => 'foo', 'BAR' => 'bar']
Iterables::mapWithKeys(
    ['foo', 'bar'],
    static fn (string $value): array => [
        mb_strtoupper($value) => $value,
    ],
);

// 'foo'
Iterables::first(['foo', 'bar']);

// false
Iterables::isEmpty(['foo', 'bar']);

// true
Iterables::isNotEmpty(['foo', 'bar']);

// ['foo', 'bar']
Iterables::keys(['foo' => 'bar', 'bar' => 'baz']);

// [[1, 2], [3]]
Iterables::chunk([1, 2, 3], 2);
```

## License

This package is licensed under the MIT License.
