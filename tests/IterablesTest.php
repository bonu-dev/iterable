<?php

declare(strict_types = 1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;

final class IterablesTest extends TestCase
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
    public function itReturnsIfIterableIsEmpty(): void
    {
        $this->assertTrue(Iterables::isEmpty([]));
        $this->assertFalse(Iterables::isEmpty(['foo']));
    }

    /**
     * @test
     */
    public function itReturnsIfIterableIsNotEmpty(): void
    {
        $this->assertFalse(Iterables::isNotEmpty([]));
        $this->assertTrue(Iterables::isNotEmpty(['foo']));
    }

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
    public function itReturnsFirstValueInIterable(): void
    {
        $this->assertSame(
            'foo',
            Iterables::first(['foo', 'bar']),
        );
    }

    /**
     * @test
     */
    public function itReturnsKeys(): void
    {
        $keys = Iterables::keys([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        $this->assertSame(['foo', 'bar'], \iterator_to_array($keys));
    }
}