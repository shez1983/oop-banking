<?php

namespace Tests\Unit;

use Bank\Customer;
use Bank\Account;
use Bank\Enums\AccountType;
use Bank\Enums\CustomerType;
use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidAmountException;
use Bank\Transaction;
use Exception;
use Tests\TestCase;

class AccountTest extends TestCase
{
    public function test_that_i_can_create_a_new_account(): void
    {
        $account = new Account(AccountType::Saving->name);

        $this->assertTrue($account->getType() === 'Saving');
    }

    public function test_that_i_cannot_create_a_new_account_if_invalid_type(): void
    {
        $this->expectException(Exception::class);

        $account = new Account('Invalid');

        $this->assertFalse(is_object($account));
    }

    public function test_i_can_add_transaction_to_account()
    {
        $account = new Account(AccountType::Current->name);

        $transaction = new Transaction(TransactionType::Topup->name, 100, 'ref');

        $account->addTransaction($transaction);

        $this->assertCount(1, $account->getTransactions());
    }

    public function test_i_cannot_add_transaction_to_account_if_it_is_greater_than_topup_limit()
    {
        $this->expectException(InvalidAmountException::class);

        $account = new Account(AccountType::Current->name, 200);

        $transaction = new Transaction(TransactionType::Topup->name, 300, 'ref');

        $account->addTransaction($transaction);

        $this->assertCount(0, $account->getTransactions());
    }

    public function test_topup_transaction_limit_does_not_take_any_withdrawals_into_account()
    {
        $this->expectException(InvalidAmountException::class);

        $account = new Account(AccountType::Current->name, 200);

        $transaction = new Transaction(TransactionType::Topup->name, 120, 'ref');
        $account->addTransaction($transaction);

        $transaction = new Transaction(TransactionType::Withdraw->name, -20, 'ref');
        $account->addTransaction($transaction);

        $transaction = new Transaction(TransactionType::Topup->name, 100, 'ref');
        $account->addTransaction($transaction);

        $this->assertCount(2, $account->getTransactions());
    }

    public function test_i_cannot_add_transaction_to_account_if_it_takes_you_over_topup_limit()
    {
        $this->expectException(InvalidAmountException::class);

        $account = new Account(AccountType::Current->name, 200);

        $transaction = new Transaction(TransactionType::Topup->name, 100, 'ref');
        $account->addTransaction($transaction);

        $transaction2 = new Transaction(TransactionType::Topup->name, 101, 'ref');
        $account->addTransaction($transaction2);

        $this->assertCount(1, $account->getTransactions());
    }

    public function test_i_cannot_add_withdrawal_transaction_to_account_if_balance_will_become_less_than_0()
    {
        $this->expectException(InvalidAmountException::class);

        $account = new Account(AccountType::Current->name, 200);

        $transaction = new Transaction(TransactionType::Topup->name, 100, 'ref');
        $account->addTransaction($transaction);

        $transaction2 = new Transaction(TransactionType::Withdraw->name, -101, 'ref');
        $account->addTransaction($transaction2);

        $this->assertCount(1, $account->getTransactions());
    }


    public function test_i_can_add_transaction_to_account_if_it_previous_trans_done_yesterday()
    {
        $this->travel(-1)->days();

        $account = new Account(AccountType::Current->name, 200);

        $transaction = new Transaction(TransactionType::Topup->name, 100, 'ref');
        $account->addTransaction($transaction);

        $this->travelBack();

        $transaction2 = new Transaction(TransactionType::Topup->name, 101, 'ref');
        $account->addTransaction($transaction2);

        $this->assertCount(2, $account->getTransactions());
    }

    public function test_i_can_get_account_balance()
    {
        $account = new Account(AccountType::Current->name, 200);

        $transaction = new Transaction(TransactionType::Topup->name, 100, 'ref');
        $account->addTransaction($transaction);

        $transaction = new Transaction(TransactionType::Withdraw->name, -10, 'ref');
        $account->addTransaction($transaction);

        $this->assertEquals(90, $account->getBalance());
    }
}
