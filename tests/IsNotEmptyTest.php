<?php

declare(strict_types=1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;

final class IsNotEmptyTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsIfIterableIsNotEmpty(): void
    {
        $this->assertFalse(Iterables::isNotEmpty([]));
        $this->assertTrue(Iterables::isNotEmpty(['foo']));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsFalseForEmptyArrayWithMixedKeys(): void
    {
        $this->assertFalse(Iterables::isNotEmpty([]));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsTrueForArrayWithNullValue(): void
    {
        $this->assertTrue(Iterables::isNotEmpty([null]));
        $this->assertTrue(Iterables::isNotEmpty([0 => null]));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsTrueForArrayWithFalsyValues(): void
    {
        $this->assertTrue(Iterables::isNotEmpty([0]));
        $this->assertTrue(Iterables::isNotEmpty([false]));
        $this->assertTrue(Iterables::isNotEmpty(['']));
        $this->assertTrue(Iterables::isNotEmpty([0.0]));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsTrueForArrayWithStringKeys(): void
    {
        $this->assertTrue(Iterables::isNotEmpty(['key' => 'value']));
        $this->assertTrue(Iterables::isNotEmpty(['' => 'empty key']));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsTrueForArrayWithNumericKeys(): void
    {
        $this->assertTrue(Iterables::isNotEmpty([100 => 'value']));
        $this->assertTrue(Iterables::isNotEmpty([-1 => 'negative key']));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itHandlesEmptyGenerator(): void
    {
        $emptyGenerator = function (): \Generator {
            return;
            yield; // Never reached
        };

        $this->assertFalse(Iterables::isNotEmpty($emptyGenerator()));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itHandlesNonEmptyGenerator(): void
    {
        $generator = function (): \Generator {
            yield 'value';
        };

        $this->assertTrue(Iterables::isNotEmpty($generator()));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itHandlesEmptyArrayObject(): void
    {
        $emptyArrayObject = new \ArrayObject([]);
        $this->assertFalse(Iterables::isNotEmpty($emptyArrayObject));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itHandlesNonEmptyArrayObject(): void
    {
        $arrayObject = new \ArrayObject(['value']);
        $this->assertTrue(Iterables::isNotEmpty($arrayObject));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itHandlesArrayIterator(): void
    {
        $emptyIterator = new \ArrayIterator([]);
        $nonEmptyIterator = new \ArrayIterator(['value']);

        $this->assertFalse(Iterables::isNotEmpty($emptyIterator));
        $this->assertTrue(Iterables::isNotEmpty($nonEmptyIterator));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itHandlesSingleElementIterables(): void
    {
        $this->assertTrue(Iterables::isNotEmpty([1]));
        $this->assertTrue(Iterables::isNotEmpty(['single']));
        $this->assertTrue(Iterables::isNotEmpty(['key' => 'single']));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itHandlesMultipleElementIterables(): void
    {
        $this->assertTrue(Iterables::isNotEmpty([1, 2, 3]));
        $this->assertTrue(Iterables::isNotEmpty(['a' => 1, 'b' => 2]));
        $this->assertTrue(Iterables::isNotEmpty([null, false, 0, '']));
    }
}
