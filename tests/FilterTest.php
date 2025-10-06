<?php

declare(strict_types=1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;
use PHPUnit\Framework\Attributes\Test;

final class FilterTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersIterableWithCallback(): void
    {
        $filtered = Iterables::filter(
            [1, 2, 3, 4, 5],
            static fn (int $value): bool => $value % 2 === 0
        );

        $this->assertSame([1 => 2, 3 => 4], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersEmptyIterable(): void
    {
        $filtered = Iterables::filter(
            [],
            static fn (mixed $value): bool => true
        );

        $this->assertSame([], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersWithNoMatches(): void
    {
        $filtered = Iterables::filter(
            [1, 3, 5],
            static fn (int $value): bool => $value % 2 === 0
        );

        $this->assertSame([], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersWithAllMatches(): void
    {
        $filtered = Iterables::filter(
            ['a', 'b', 'c'],
            static fn (string $value): bool => true
        );

        $this->assertSame(['a', 'b', 'c'], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersWithNullValues(): void
    {
        $filtered = Iterables::filter(
            [null, 'value', null, 42],
            static fn (mixed $value): bool => $value !== null
        );

        $this->assertSame([1 => 'value', 3 => 42], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersWithMixedTypes(): void
    {
        $filtered = Iterables::filter(
            ['string', 123, true, false, [], ['not empty']],
            static fn (mixed $value): bool => !empty($value)
        );

        $this->assertSame(['string', 123, true, ['not empty']], \array_values(\iterator_to_array($filtered)));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersWithKeyBasedCallback(): void
    {
        $filtered = Iterables::filter(
            ['a' => 1, 'b' => 2, 'c' => 3],
            static fn (int $value, string $key): bool => $key !== 'b'
        );

        $this->assertSame(['a' => 1, 'c' => 3], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersWithStrictBooleanCheck(): void
    {
        $filtered = Iterables::filter(
            [1, 0, 'truthy', '', null, false, true],
            static fn (mixed $value): bool => $value === true
        );

        $this->assertSame([6 => true], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersWithCallbackReturningNonBoolean(): void
    {
        $filtered = Iterables::filter(
            [1, 2, 3, 4],
            static fn (int $value): int => $value % 2 // Returns 0 or 1
        );

        $this->assertSame([], \iterator_to_array($filtered)); // Should be empty as callback never returns exactly true
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersWithCallbackReturningTruthyButNotTrue(): void
    {
        $filtered = Iterables::filter(
            ['a', 'b', 'c'],
            static fn (string $value): string => $value // Returns string (truthy but not true)
        );

        $this->assertSame([], \iterator_to_array($filtered)); // Should be empty as callback never returns exactly true
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersStringKeys(): void
    {
        $filtered = Iterables::filter(
            ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3'],
            static fn (string $value, string $key): bool => \str_contains($key, '2')
        );

        $this->assertSame(['key2' => 'value2'], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersGenerator(): void
    {
        $generator = function (): \Generator {
            yield 'first' => 1;
            yield 'second' => 2;
            yield 'third' => 3;
        };

        $filtered = Iterables::filter(
            $generator(),
            static fn (int $value): bool => $value > 1
        );

        $this->assertSame(['second' => 2, 'third' => 3], \iterator_to_array($filtered));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFiltersArrayObject(): void
    {
        $arrayObject = new \ArrayObject(['x' => 10, 'y' => 20, 'z' => 30]);

        $filtered = Iterables::filter(
            $arrayObject,
            static fn (int $value): bool => $value >= 20
        );

        $this->assertSame(['y' => 20, 'z' => 30], \iterator_to_array($filtered));
    }
}
