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
    public function test_that_i_can_create_a_new_topup_transaction(): void
    {
        $transaction = new Transaction(TransactionType::Topup->name, 200, 'savings');

        $this->assertTrue($transaction->getAmount() === 200);
    }

    public function test_that_i_can_create_a_new_withdrawal_transaction_if_amount_less_than_1(): void
    {
        $transaction = new Transaction(TransactionType::Withdraw->name, -13, 'savings');
        $this->assertTrue(is_object($transaction));
    }

    public function test_that_i_cannot_create_a_new_transaction_if_invalid_type(): void
    {
        $this->expectException(InvalidTypeException::class);

        $transaction = new Transaction('invalid', 200, 'savings');

        $this->assertFalse(is_object($transaction));
    }

    public function test_that_i_cannot_create_a_new_topup_transaction_if_amount_less_than_1(): void
    {
        $this->expectException(InvalidAmountException::class);

        $transaction = new Transaction(TransactionType::Topup->name, -1, 'savings');
        $this->assertFalse(is_object($transaction));

        $transaction = new Transaction(TransactionType::Topup->name, 0, 'savings');
        $this->assertFalse(is_object($transaction));
    }

    public function test_that_i_cannot_create_a_new_withdraw_transaction_if_amount_greater_than_equal_to_0(): void
    {
        $this->expectException(InvalidAmountException::class);

        $transaction = new Transaction(TransactionType::Withdraw->name, 0, 'savings');
        $this->assertFalse(is_object($transaction));

        $transaction = new Transaction(TransactionType::Withdraw->name, 200, 'savings');
        $this->assertFalse(is_object($transaction));
    }
}
