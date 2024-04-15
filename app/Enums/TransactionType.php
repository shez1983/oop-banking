<?php

namespace Bank\Enums;

enum TransactionType
{
    case Withdraw;
    case Topup;
    case Transfer; // is it same as withdraw?

    public static function all(): array
    {
        return array_column(self::cases(), 'name');
    }
}
