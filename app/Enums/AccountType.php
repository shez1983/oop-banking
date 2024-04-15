<?php

namespace Bank\Enums;

enum AccountType
{
    case Saving;
    case Current;

    public static function all(): array
    {
        return array_column(self::cases(), 'name');
    }
}
