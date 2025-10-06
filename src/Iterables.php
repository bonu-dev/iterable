<?php

declare(strict_types = 1);

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
     * @template TReduce
     * @template TReduceInitial
     *
     * @param iterable<TKey, TValue> $iterable
     * @param (callable(TReduce|TReduceInitial, TValue, TKey): TReduce) $callback
     * @param TReduceInitial $initial
     *
     * @return TReduceInitial|TReduce
     */
    public static function reduce(
        iterable $iterable,
        callable $callback,
        mixed $initial = null,
    ): mixed {
        $result = $initial;

        foreach ($iterable as $key => $value) {
            $result = $callback($result, $value, $key);
        }

        return $result;
    }
}