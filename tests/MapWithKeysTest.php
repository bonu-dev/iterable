<?php

declare(strict_types=1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;

final class MapWithKeysTest extends TestCase
{
    /**
     * @test
     */
    public function itMapsIterableWithKeysViaGivenCallable(): void
    {
        $mapped = Iterables::mapWithKeys(
            ['foo', 'bar'],
            static fn (string $value): array => [
                \strtoupper($value) => $value,
            ],
        );

        $this->assertSame(['FOO' => 'foo', 'BAR' => 'bar'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsEmptyIterable(): void
    {
        $mapped = Iterables::mapWithKeys(
            [],
            static fn (mixed $value): array => ['key' => 'value'],
        );

        $this->assertSame([], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsSingleElementIterable(): void
    {
        $mapped = Iterables::mapWithKeys(
            ['single'],
            static fn (string $value): array => [$value => \strtoupper($value)],
        );

        $this->assertSame(['single' => 'SINGLE'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithMultipleKeysPerElement(): void
    {
        $mapped = Iterables::mapWithKeys(
            ['test'],
            static fn (string $value): array => [
                $value => 'original',
                \strtoupper($value) => 'uppercase',
                \strlen($value) => 'length',
            ],
        );

        $this->assertSame(['test' => 'original', 'TEST' => 'uppercase', 4 => 'length'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithNullValues(): void
    {
        $mapped = Iterables::mapWithKeys(
            [null, 'value'],
            static fn (mixed $value): array => [
                $value ?? 'null_key' => $value ?? 'null_value',
            ],
        );

        $this->assertSame(['null_key' => 'null_value', 'value' => 'value'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithMixedTypes(): void
    {
        $mapped = Iterables::mapWithKeys(
            ['string', 123, true],
            static fn (mixed $value): array => [
                \gettype($value) => $value,
            ],
        );

        $this->assertSame(['string' => 'string', 'integer' => 123, 'boolean' => true], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithOriginalKeys(): void
    {
        $mapped = Iterables::mapWithKeys(
            ['a' => 1, 'b' => 2, 'c' => 3],
            static fn (int $value, string $key): array => [
                $key . '_new' => $value * 10,
                $key . '_original' => $value,
            ],
        );

        $expected = [
            'a_new' => 10,
            'a_original' => 1,
            'b_new' => 20,
            'b_original' => 2,
            'c_new' => 30,
            'c_original' => 3,
        ];

        $this->assertSame($expected, \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithNumericKeys(): void
    {
        $mapped = Iterables::mapWithKeys(
            [10 => 'ten', 20 => 'twenty'],
            static fn (string $value, int $key): array => [
                $key * 2 => $value . '_doubled',
            ],
        );

        $this->assertSame([20 => 'ten_doubled', 40 => 'twenty_doubled'], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsGenerator(): void
    {
        $generator = function (): \Generator {
            yield 'first' => 1;
            yield 'second' => 2;
        };

        $mapped = Iterables::mapWithKeys(
            $generator(),
            static fn (int $value, string $key): array => [
                $key . '_mapped' => $value * 100,
            ],
        );

        $this->assertSame(['first_mapped' => 100, 'second_mapped' => 200], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsArrayObject(): void
    {
        $arrayObject = new \ArrayObject(['x' => 5, 'y' => 10]);

        $mapped = Iterables::mapWithKeys(
            $arrayObject,
            static fn (int $value, string $key): array => [
                $key . '_squared' => $value * $value,
            ],
        );

        $this->assertSame(['x_squared' => 25, 'y_squared' => 100], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithEmptyArrayReturned(): void
    {
        $mapped = Iterables::mapWithKeys(
            ['foo', 'bar'],
            static fn (string $value): array => [], // Returns empty array
        );

        $this->assertSame([], \iterator_to_array($mapped));
    }

    /**
     * @test
     */
    public function itMapsWithOverlappingKeys(): void
    {
        $mapped = Iterables::mapWithKeys(
            ['first', 'second'],
            static fn (string $value): array => [
                'same_key' => $value, // Same key for all elements
            ],
        );

        // Later values should overwrite earlier ones
        $this->assertSame(['same_key' => 'second'], \iterator_to_array($mapped));
    }
}
