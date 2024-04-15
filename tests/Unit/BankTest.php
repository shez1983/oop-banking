<?php

namespace Tests\Unit;

use Bank\Account;
use Bank\Bank;
use Bank\Customer;
use Bank\Enums\AccountType;
use Bank\Enums\CustomerType;
use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InvalidTypeException;
use Bank\Transaction;
use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{
    public function test_that_i_can_create_whole_flow(): void
    {
        $bank = new Bank();

        // @todo cant have same customer again
        $customer = new Customer(CustomerType::Personal->name, 'Shez Azr');
        $account = new Account(AccountType::Current->name);

        $customer->addAccounts($account);

        $transaction = new Transaction(TransactionType::Topup->name, 200, 'ref');

        // $account->


    }
}
