<?php

declare(strict_types=1);

namespace Bonu\Iterable;

class Iterables
{
    /**
     * @template TKey of array-key
     * @template TInitialValue of mixed
     * @template TMappedValue of mixed
     *
     * @param iterable<TKey, TInitialValue> $iterable
     * @param callable(TInitialValue, TKey): TMappedValue  $callback
     *
     * @return \Generator<TKey, TMappedValue>
     */
    public static function map(iterable $iterable, callable $callback): \Generator
    {
        foreach ($iterable as $key => $value) {
            yield $key => $callback($value, $key);
        }
    }

    /**
     * @template TKey of array-key
     * @template TMappedKey of array-key
     * @template TInitialValue of mixed
     * @template TMappedValue of mixed
     *
     * @param iterable<TKey, TInitialValue> $iterable
     * @param callable(TInitialValue, TKey): array<TMappedKey, TMappedValue>  $callback
     *
     * @return \Generator<TMappedKey, TMappedValue>
     */
    public static function mapWithKeys(iterable $iterable, callable $callback): \Generator
    {
        foreach ($iterable as $key => $value) {
            yield from $callback($value, $key);
        }
    }

    /**
     * @template TValue
     *
     * @param iterable<array-key, TValue> $iterable
     *
     * @return TValue|null
     */
    public static function first(iterable $iterable): mixed
    {
        foreach ($iterable as $value) {
            return $value;
        }

        return null;
    }

    /**
     * @param iterable<array-key, mixed> $iterable
     *
     * @return bool
     */
    public static function isEmpty(iterable $iterable): bool
    {
        foreach ($iterable as $_) {
            return false;
        }

        return true;
    }

    /**
     * @param iterable<array-key, mixed> $iterable
     *
     * @return bool
     */
    public static function isNotEmpty(iterable $iterable): bool
    {
        return ! self::isEmpty($iterable);
    }

    /**
     * @template TKey of array-key
     *
     * @param iterable<TKey, mixed> $iterable
     *
     * @return \Generator<array-key, TKey>
     */
    public static function keys(iterable $iterable): \Generator
    {
        foreach ($iterable as $key => $_) {
            yield $key;
        }
    }

    /**
     * @template TKey of array-key
     * @template TValue
     *
     * @param iterable<TKey, TValue> $iterable
     * @param (callable(TValue, TKey): bool) $callback Callback must return the boolean true to include an item. Truthy non-bool values (e.g. 1, "yes") are excluded.
     *
     * @return \Generator<TKey, TValue>
     */
    public static function filter(iterable $iterable, callable $callback): \Generator
    {
        foreach ($iterable as $key => $value) {
            if ($callback($value, $key) === true) {
                yield $key => $value;
            }
        }
    }

    /**
     * @template TValue
     *
     * @param iterable<array-key, TValue> $iterable
     * @param int<0, max> $size
     *
     * @return \Generator<array-key, list<TValue>>
     */
    public static function chunk(iterable $iterable, int $size): \Generator
    {
        $currentChunk = [];
        $chunkIndex = 0;

        foreach ($iterable as $item) {
            $currentChunk[] = $item;

            $chunkIndex++;

            if ($chunkIndex >= $size) {
                yield $currentChunk;
                $currentChunk = [];
                $chunkIndex = 0;
            }
        }

        if ($currentChunk !== []) {
            yield $currentChunk;
        }
    }
}
