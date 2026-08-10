<?php

declare(strict_types=1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;
use PHPUnit\Framework\Attributes\Test;

/**
 * @internal
 */
final class IsEmptyTest extends TestCase
{
    #[Test]
    public function itReturnsIfIterableIsEmpty(): void
    {
        $this->assertTrue(Iterables::isEmpty([]));
        $this->assertFalse(Iterables::isEmpty(['foo']));
    }

    #[Test]
    public function itReturnsTrueForEmptyArrayWithMixedKeys(): void
    {
        $this->assertTrue(Iterables::isEmpty([]));
    }

    #[Test]
    public function itReturnsFalseForArrayWithNullValue(): void
    {
        $this->assertFalse(Iterables::isEmpty([null]));
        $this->assertFalse(Iterables::isEmpty([0 => null]));
    }

    #[Test]
    public function itReturnsFalseForArrayWithFalsyValues(): void
    {
        $this->assertFalse(Iterables::isEmpty([0]));
        $this->assertFalse(Iterables::isEmpty([false]));
        $this->assertFalse(Iterables::isEmpty(['']));
        $this->assertFalse(Iterables::isEmpty([0.0]));
    }

    #[Test]
    public function itReturnsFalseForArrayWithStringKeys(): void
    {
        $this->assertFalse(Iterables::isEmpty(['key' => 'value']));
        $this->assertFalse(Iterables::isEmpty(['' => 'empty key']));
    }

    #[Test]
    public function itReturnsFalseForArrayWithNumericKeys(): void
    {
        $this->assertFalse(Iterables::isEmpty([100 => 'value']));
        $this->assertFalse(Iterables::isEmpty([-1 => 'negative key']));
    }

    #[Test]
    public function itHandlesEmptyGenerator(): void
    {
        $emptyGenerator = function (): \Generator {
        };

        $this->assertTrue(Iterables::isEmpty($emptyGenerator()));
    }

    #[Test]
    public function itHandlesNonEmptyGenerator(): void
    {
        $generator = function (): \Generator {
            yield 'value';
        };

        $this->assertFalse(Iterables::isEmpty($generator()));
    }

    #[Test]
    public function itHandlesEmptyArrayObject(): void
    {
        $emptyArrayObject = new \ArrayObject([]);
        $this->assertTrue(Iterables::isEmpty($emptyArrayObject));
    }

    #[Test]
    public function itHandlesNonEmptyArrayObject(): void
    {
        $arrayObject = new \ArrayObject(['value']);
        $this->assertFalse(Iterables::isEmpty($arrayObject));
    }

    #[Test]
    public function itHandlesArrayIterator(): void
    {
        $emptyIterator = new \ArrayIterator([]);
        $nonEmptyIterator = new \ArrayIterator(['value']);

        $this->assertTrue(Iterables::isEmpty($emptyIterator));
        $this->assertFalse(Iterables::isEmpty($nonEmptyIterator));
    }

    #[Test]
    public function itHandlesSingleElementIterables(): void
    {
        $this->assertFalse(Iterables::isEmpty([1]));
        $this->assertFalse(Iterables::isEmpty(['single']));
        $this->assertFalse(Iterables::isEmpty(['key' => 'single']));
    }
}
