<?php

namespace Tests\Unit;

use Bank\Bank;
use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{
    public function test_that_i_can_create_a_new_transaction(): void
    {
        $bank = new Bank();
    }
}
