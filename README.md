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
```

## License

This package is licensed under the MIT License.