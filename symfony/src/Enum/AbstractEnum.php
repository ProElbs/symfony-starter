<?php

namespace App\Enum;

abstract class AbstractEnum
{
    /**  @return array<string, mixed> List of all constants */
    public static function getConstants(): array
    {
        return (new \ReflectionClass(static::class))->getConstants();
    }

    /**  @return array<int, string> */
    public static function getValues(): array
    {
        return array_values(self::getConstants());
    }
}
