<?php

declare(strict_types=1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;

final class IsEmptyTest extends TestCase
{
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
    public function itReturnsTrueForEmptyArrayWithMixedKeys(): void
    {
        $this->assertTrue(Iterables::isEmpty([]));
        $this->assertTrue(Iterables::isEmpty(array()));
    }

    /**
     * @test
     */
    public function itReturnsFalseForArrayWithNullValue(): void
    {
        $this->assertFalse(Iterables::isEmpty([null]));
        $this->assertFalse(Iterables::isEmpty([0 => null]));
    }

    /**
     * @test
     */
    public function itReturnsFalseForArrayWithFalsyValues(): void
    {
        $this->assertFalse(Iterables::isEmpty([0]));
        $this->assertFalse(Iterables::isEmpty([false]));
        $this->assertFalse(Iterables::isEmpty(['']));
        $this->assertFalse(Iterables::isEmpty([0.0]));
    }

    /**
     * @test
     */
    public function itReturnsFalseForArrayWithStringKeys(): void
    {
        $this->assertFalse(Iterables::isEmpty(['key' => 'value']));
        $this->assertFalse(Iterables::isEmpty(['' => 'empty key']));
    }

    /**
     * @test
     */
    public function itReturnsFalseForArrayWithNumericKeys(): void
    {
        $this->assertFalse(Iterables::isEmpty([100 => 'value']));
        $this->assertFalse(Iterables::isEmpty([-1 => 'negative key']));
    }

    /**
     * @test
     */
    public function itHandlesEmptyGenerator(): void
    {
        $emptyGenerator = function (): \Generator {
            return;
            yield; // Never reached
        };

        $this->assertTrue(Iterables::isEmpty($emptyGenerator()));
    }

    /**
     * @test
     */
    public function itHandlesNonEmptyGenerator(): void
    {
        $generator = function (): \Generator {
            yield 'value';
        };

        $this->assertFalse(Iterables::isEmpty($generator()));
    }

    /**
     * @test
     */
    public function itHandlesEmptyArrayObject(): void
    {
        $emptyArrayObject = new \ArrayObject([]);
        $this->assertTrue(Iterables::isEmpty($emptyArrayObject));
    }

    /**
     * @test
     */
    public function itHandlesNonEmptyArrayObject(): void
    {
        $arrayObject = new \ArrayObject(['value']);
        $this->assertFalse(Iterables::isEmpty($arrayObject));
    }

    /**
     * @test
     */
    public function itHandlesArrayIterator(): void
    {
        $emptyIterator = new \ArrayIterator([]);
        $nonEmptyIterator = new \ArrayIterator(['value']);

        $this->assertTrue(Iterables::isEmpty($emptyIterator));
        $this->assertFalse(Iterables::isEmpty($nonEmptyIterator));
    }

    /**
     * @test
     */
    public function itHandlesSingleElementIterables(): void
    {
        $this->assertFalse(Iterables::isEmpty([1]));
        $this->assertFalse(Iterables::isEmpty(['single']));
        $this->assertFalse(Iterables::isEmpty(['key' => 'single']));
    }
}
