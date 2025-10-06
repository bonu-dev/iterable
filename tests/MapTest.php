<?php

declare(strict_types = 1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;

final class MapTest extends TestCase
{
    /**
     * @test
     */
    public function itMapsIterableViaGivenCallback(): void
    {
        $mapped = Iterables::map(
            ['foo', 'bar'],
            static fn (string $value): string => \strtoupper($value),
        );

        $this->assertSame(['FOO', 'BAR'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsEmptyIterable(): void
    {
        $mapped = Iterables::map(
            [],
            static fn (mixed $value): string => 'transformed',
        );

        $this->assertSame([], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsSingleElementIterable(): void
    {
        $mapped = Iterables::map(
            ['single'],
            static fn (string $value): string => \strtoupper($value),
        );

        $this->assertSame(['SINGLE'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithNullValues(): void
    {
        $mapped = Iterables::map(
            [null, 'value', null],
            static fn (mixed $value): string => $value ?? 'NULL',
        );

        $this->assertSame(['NULL', 'value', 'NULL'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithMixedTypes(): void
    {
        $mapped = Iterables::map(
            ['string', 123, true, false, []],
            static fn (mixed $value): string => \gettype($value),
        );

        $this->assertSame(['string', 'integer', 'boolean', 'boolean', 'array'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithStringKeys(): void
    {
        $mapped = Iterables::map(
            ['key1' => 'value1', 'key2' => 'value2'],
            static fn (string $value, string $key): string => $key . ':' . $value,
        );

        $this->assertSame(['key1' => 'key1:value1', 'key2' => 'key2:value2'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithNumericKeys(): void
    {
        $mapped = Iterables::map(
            [10 => 'ten', 20 => 'twenty'],
            static fn (string $value, int $key): string => $key . ':' . $value,
        );

        $this->assertSame([10 => '10:ten', 20 => '20:twenty'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsGenerator(): void
    {
        $generator = function (): \Generator {
            yield 'first' => 1;
            yield 'second' => 2;
            yield 'third' => 3;
        };

        $mapped = Iterables::map(
            $generator(),
            static fn (int $value): int => $value * 2,
        );

        $this->assertSame(['first' => 2, 'second' => 4, 'third' => 6], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsArrayObject(): void
    {
        $arrayObject = new \ArrayObject(['a' => 10, 'b' => 20, 'c' => 30]);

        $mapped = Iterables::map(
            $arrayObject,
            static fn (int $value): int => $value / 10,
        );

        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithCallbackUsingBothValueAndKey(): void
    {
        $mapped = Iterables::map(
            ['x' => 5, 'y' => 10, 'z' => 15],
            static fn (int $value, string $key): array => [$key => $value * 2],
        );

        $expected = [
            'x' => ['x' => 10],
            'y' => ['y' => 20],
            'z' => ['z' => 30],
        ];

        $this->assertSame($expected, \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsPreservingOriginalKeys(): void
    {
        $mapped = Iterables::map(
            [100 => 'a', 200 => 'b', 300 => 'c'],
            static fn (string $value): string => \strtoupper($value),
        );

        $this->assertSame([100 => 'A', 200 => 'B', 300 => 'C'], \iterator_to_array($mapped));
    }
}