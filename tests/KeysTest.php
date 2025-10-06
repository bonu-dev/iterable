<?php

declare(strict_types=1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;

final class KeysTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsKeys(): void
    {
        $keys = Iterables::keys([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        $this->assertSame(['foo', 'bar'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsEmptyArrayForEmptyIterable(): void
    {
        $keys = Iterables::keys([]);
        $this->assertSame([], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsSingleKey(): void
    {
        $keys = Iterables::keys(['single' => 'value']);
        $this->assertSame(['single'], \iterator_to_array($keys));

        $keys = Iterables::keys([42 => 'numeric key']);
        $this->assertSame([42], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsNumericKeys(): void
    {
        $keys = Iterables::keys([0 => 'zero', 1 => 'one', 2 => 'two']);
        $this->assertSame([0, 1, 2], \iterator_to_array($keys));

        $keys = Iterables::keys([100 => 'hundred', 200 => 'two hundred']);
        $this->assertSame([100, 200], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsNegativeNumericKeys(): void
    {
        $keys = Iterables::keys([-1 => 'negative one', -5 => 'negative five']);
        $this->assertSame([-1, -5], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsStringKeys(): void
    {
        $keys = Iterables::keys(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(['a', 'b', 'c'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsEmptyStringKey(): void
    {
        $keys = Iterables::keys(['' => 'empty key', 'normal' => 'normal key']);
        $this->assertSame(['', 'normal'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsMixedKeyTypes(): void
    {
        $keys = Iterables::keys([0 => 'zero', 'string' => 'value', 42 => 'forty-two', 'another' => 'text']);
        $this->assertSame([0, 'string', 42, 'another'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsKeysWithNullValues(): void
    {
        $keys = Iterables::keys(['key1' => null, 'key2' => 'value', 'key3' => null]);
        $this->assertSame(['key1', 'key2', 'key3'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsKeysWithFalsyValues(): void
    {
        $keys = Iterables::keys([
            'zero' => 0,
            'false' => false,
            'empty' => '',
            'null' => null,
            'float_zero' => 0.0,
        ]);

        $this->assertSame(['zero', 'false', 'empty', 'null', 'float_zero'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsKeysFromGenerator(): void
    {
        $generator = function (): \Generator {
            yield 'first' => 1;
            yield 'second' => 2;
            yield 'third' => 3;
        };

        $keys = Iterables::keys($generator());
        $this->assertSame(['first', 'second', 'third'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsEmptyForEmptyGenerator(): void
    {
        $emptyGenerator = function (): \Generator {
            return;
            yield; // Never reached
        };

        $keys = Iterables::keys($emptyGenerator());
        $this->assertSame([], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsKeysFromArrayObject(): void
    {
        $arrayObject = new \ArrayObject(['x' => 10, 'y' => 20, 'z' => 30]);
        $keys = Iterables::keys($arrayObject);
        $this->assertSame(['x', 'y', 'z'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsEmptyForEmptyArrayObject(): void
    {
        $emptyArrayObject = new \ArrayObject([]);
        $keys = Iterables::keys($emptyArrayObject);
        $this->assertSame([], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsKeysFromArrayIterator(): void
    {
        $iterator = new \ArrayIterator(['a' => 'alpha', 'b' => 'beta']);
        $keys = Iterables::keys($iterator);
        $this->assertSame(['a', 'b'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itPreservesKeyOrder(): void
    {
        // Keys should be returned in iteration order
        $keys = Iterables::keys([3 => 'three', 1 => 'one', 2 => 'two']);
        $this->assertSame([3, 1, 2], \iterator_to_array($keys));

        $keys = Iterables::keys(['z' => 'zeta', 'a' => 'alpha', 'm' => 'mu']);
        $this->assertSame(['z', 'a', 'm'], \iterator_to_array($keys));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsKeysWithComplexValues(): void
    {
        $keys = Iterables::keys([
            'array' => [1, 2, 3],
            'object' => new \stdClass(),
            'callable' => fn () => 'test',
        ]);

        $this->assertSame(['array', 'object', 'callable'], \iterator_to_array($keys));
    }
}
