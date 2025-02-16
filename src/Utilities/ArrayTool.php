<?php
namespace PHPJava\Utilities;

class ArrayTool
{
    public static function concat(&$basedArray, ...$elements): void
    {
        if (empty($elements)) {
            return;
        }
        array_push(
            $basedArray,
            ...$elements
        );
    }

    public static function stringify(array $array): string
    {
        return implode(
            array_map(
                static function ($value) {
                    if (is_object($value)) {
                        return spl_object_hash($value);
                    }
                    if (is_array($value)) {
                        return static::stringify($value);
                    }
                    return $value;
                },
                $array
            )
        );
    }

    public static function compare(array $array1, array $array2): bool
    {
        return static::stringify($array1) === static::stringify($array2);
    }

    public static function containInMultipleDimension(array $array, $targetKey, $value): ?array
    {
        foreach ($array as $element) {
            if (!is_array($element)) {
                return false;
            }
            if (array_key_exists($targetKey, $element)
                && $element[$targetKey] === $value
            ) {
                return $element;
            }
        }
        return null;
    }

    public static function deepCopy(array $array): array
    {
        array_walk_recursive(
            $array,
            static function (&$element) {
                if (is_object($element)) {
                    $element = clone $element;
                }
            }
        );
        return $array;
    }
}
