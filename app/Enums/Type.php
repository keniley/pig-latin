<?php

namespace App\Enums;

enum Type: string
{
    case SNAKE_CASE = 'snake_case';
    case CAMEL_CASE = 'camelCase';
    case AI = 'ai';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
