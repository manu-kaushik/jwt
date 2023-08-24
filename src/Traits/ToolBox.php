<?php

namespace BitterByter\JWT\Traits;

/**
 * `ToolBox` holds the implementations that are required by the `JWT` class.
 */
trait ToolBox
{
    /**
     * Encodes `$data` to JSON and base64.
     *
     * @param array `$data` The data to encode.
     *
     * @return string
     */
    protected static function encode(array $data): string
    {
        return base64_encode(json_encode($data));
    }

    /**
     * Decodes `$data` from base64 and JSON.
     *
     * @param string `$data` The data to decode.
     *
     * @return mixed
     */
    protected static function decode(string $data): array
    {
        return (array)json_decode(base64_decode($data));
    }

    /**
     * Concatenates `$values` with a dot(.).
     *
     * @param array `$values` The values to concatenate.
     *
     * @return string
     */
    protected static function dotUp(...$values): string
    {
        $encodedValues = [];

        foreach ($values as $value) {
            array_push(
                $encodedValues,
                is_array($value)
                    ? self::encode($value)
                    : $value
            );
        }

        return implode('.', $encodedValues);
    }
}
