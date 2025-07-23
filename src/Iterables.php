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
     * @return iterable<TKey, TMappedValue>
     */
    public static function map(iterable $iterable, callable $callback): iterable
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
     * @return iterable<TMappedKey, TMappedValue>
     */
    public static function mapWithKeys(iterable $iterable, callable $callback): iterable
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
        foreach ($iterable as $value) {
            return false;
        }

        return true;
    }
}