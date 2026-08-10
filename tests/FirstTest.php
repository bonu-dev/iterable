<?php

declare(strict_types=1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;
use PHPUnit\Framework\Attributes\Test;

use const PHP_FLOAT_EPSILON;

/**
 * @internal
 */
final class FirstTest extends TestCase
{
    #[Test]
    public function itReturnsFirstValueInIterable(): void
    {
        $this->assertSame(
            'foo',
            Iterables::first(['foo', 'bar']),
        );
    }

    #[Test]
    public function itReturnsNullIfIterableIsEmptyWhileGettingFirstValue(): void
    {
        $this->assertNull(Iterables::first([]));
    }

    #[Test]
    public function itReturnsFirstValueFromSingleElementIterable(): void
    {
        $this->assertSame('single', Iterables::first(['single']));
        $this->assertSame(42, Iterables::first([42]));
        $this->assertTrue(Iterables::first([true]));
    }

    #[Test]
    public function itReturnsNullAsFirstValue(): void
    {
        $this->assertNull(Iterables::first([null]));
        $this->assertNull(Iterables::first([null, 'second']));
    }

    #[Test]
    public function itReturnsFalsyValuesAsFirst(): void
    {
        $this->assertSame(0, Iterables::first([0, 1]));
        $this->assertFalse(Iterables::first([false, true]));
        $this->assertSame('', Iterables::first(['', 'not empty']));
        $this->assertEqualsWithDelta(0.0, Iterables::first([0.0, 1.0]), PHP_FLOAT_EPSILON);
    }

    #[Test]
    public function itReturnsFirstValueWithStringKeys(): void
    {
        $this->assertSame('value1', Iterables::first(['key1' => 'value1', 'key2' => 'value2']));
        $this->assertSame('empty key value', Iterables::first(['' => 'empty key value', 'key' => 'other']));
    }

    #[Test]
    public function itReturnsFirstValueWithNumericKeys(): void
    {
        $this->assertSame('hundred', Iterables::first([100 => 'hundred', 200 => 'two hundred']));
        $this->assertSame('negative', Iterables::first([-1 => 'negative', 0 => 'zero']));
    }

    #[Test]
    public function itReturnsFirstValueFromGenerator(): void
    {
        $generator = function (): \Generator {
            yield 'first' => 1;
            yield 'second' => 2;
            yield 'third' => 3;
        };

        $this->assertSame(1, Iterables::first($generator()));
    }

    #[Test]
    public function itReturnsNullFromEmptyGenerator(): void
    {
        $emptyGenerator = function (): \Generator {
        };

        $this->assertNull(Iterables::first($emptyGenerator()));
    }

    #[Test]
    public function itReturnsFirstValueFromArrayObject(): void
    {
        $arrayObject = new \ArrayObject(['x' => 10, 'y' => 20, 'z' => 30]);
        $this->assertSame(10, Iterables::first($arrayObject));

        $emptyArrayObject = new \ArrayObject([]);
        $this->assertNull(Iterables::first($emptyArrayObject));
    }

    #[Test]
    public function itReturnsFirstValueFromArrayIterator(): void
    {
        $iterator = new \ArrayIterator(['a', 'b', 'c']);
        $this->assertSame('a', Iterables::first($iterator));

        $emptyIterator = new \ArrayIterator([]);
        $this->assertNull(Iterables::first($emptyIterator));
    }

    #[Test]
    public function itReturnsFirstValueWithMixedTypes(): void
    {
        $this->assertSame('string', Iterables::first(['string', 123, true, [], null]));
        $this->assertSame(123, Iterables::first([123, 'string', false]));
        $this->assertTrue(Iterables::first([true, 'after boolean']));
    }

    #[Test]
    public function itReturnsFirstValueRegardlessOfKeyOrder(): void
    {
        // Arrays maintain insertion order
        $this->assertSame('first', Iterables::first([2 => 'first', 1 => 'second', 3 => 'third']));
        $this->assertSame('alpha', Iterables::first(['z' => 'alpha', 'a' => 'beta']));
    }
}
