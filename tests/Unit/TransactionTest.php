<?php

namespace Tests\Unit;

use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InvalidTypeException;
use Bank\Transaction;
use Exception;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function test_that_i_can_create_a_new_transaction(): void
    {
        $transaction = new Transaction(TransactionType::Topup->name, 200, 'savings');

        $this->assertTrue($transaction->getAmount() === 200);
    }

    public function test_that_i_cannot_create_a_new_transaction_if_invalid_type(): void
    {
        $this->expectException(InvalidTypeException::class);

        $transaction = new Transaction('invalid', 200, 'savings');

        $this->assertFalse(is_object($transaction));
    }

    public function test_that_i_cannot_create_a_new_transaction_if_amount_less_than_1(): void
    {
        $this->expectException(InvalidAmountException::class);

        $transaction = new Transaction(TransactionType::Topup->name, -1, 'savings');
        $this->assertFalse(is_object($transaction));

        $transaction = new Transaction(TransactionType::Topup->name, 0, 'savings');
        $this->assertFalse(is_object($transaction));
    }
}
