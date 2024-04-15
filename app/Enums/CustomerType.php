<?php

namespace Bank\Enums;

enum CustomerType
{
    case Personal;
    case Business;

    public static function all(): array
    {
        return array_column(self::cases(), 'name');
    }
}
