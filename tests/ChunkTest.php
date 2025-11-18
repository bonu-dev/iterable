<?php

declare(strict_types = 1);

namespace Bonu\Iterable\Tests;

use Bonu\Iterable\Iterables;

final class ChunkTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function itThrowsInvalidArgumentExceptionIfSizeIsNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        \iterator_to_array(Iterables::chunk([], -1));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itThrowsInvalidArgumentExceptionIfSizeIsZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        \iterator_to_array(Iterables::chunk([], 0));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itSplitsIterableIntoMultipleChunks(): void
    {
        $chunks = \iterator_to_array(Iterables::chunk([
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
        ], 2));

        $this->assertCount(5, $chunks);
        $this->assertSame([[1,2], [3,4], [5,6], [7,8], [9,10]], $chunks);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsEmptyForEmptyIterable(): void
    {
        $chunks = \iterator_to_array(Iterables::chunk([], 3));

        $this->assertSame([], $chunks);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itHandlesRemainderInLastChunk(): void
    {
        $chunks = \iterator_to_array(Iterables::chunk([1, 2, 3, 4, 5], 2));

        $this->assertSame([[1,2], [3,4], [5]], $chunks);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsSingleChunkWhenSizeLargerThanIterable(): void
    {
        $chunks = \iterator_to_array(Iterables::chunk([10, 20, 30], 10));

        $this->assertCount(1, $chunks);
        $this->assertSame([[10, 20, 30]], $chunks);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itSplitsIntoSingleItemChunksWhenSizeIsOne(): void
    {
        $chunks = \iterator_to_array(Iterables::chunk([1, 2, 3], 1));

        $this->assertSame([[1], [2], [3]], $chunks);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itDropsOriginalKeysInsideChunks(): void
    {
        $chunks = \iterator_to_array(Iterables::chunk([
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => 4,
        ], 3));

        // Chunks should be lists (0-indexed) of values only
        $this->assertSame([[1, 2, 3], [4]], $chunks);
        $this->assertSame([0, 1, 2], \array_keys($chunks[0]));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itChunksTraversableInputsLikeGenerators(): void
    {
        $generator = function (): \Generator {
            yield 1;
            yield 2;
            yield 3;
            yield 4;
        };

        $chunks = \iterator_to_array(Iterables::chunk($generator(), 3));

        $this->assertSame([[1, 2, 3], [4]], $chunks);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itChunksArrayObject(): void
    {
        $arrayObject = new \ArrayObject([1, 2, 3, 4, 5]);

        $chunks = \iterator_to_array(Iterables::chunk($arrayObject, 2));

        $this->assertSame([[1, 2], [3, 4], [5]], $chunks);
    }
}