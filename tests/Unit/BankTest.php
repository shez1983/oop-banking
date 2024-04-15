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
use Exception;
use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{
    public function test_i_can_add_customer_to_the_bank(): void
    {
        $bank = new Bank();

        $customer = new Customer(CustomerType::Personal->name, 'Shez Azr');

        $bank->addCustomer($customer);

        $this->assertCount(1, $bank->getCustomers());
    }

    public function test_i_cannot_add_customer_with_same_name_to_the_bank(): void
    {
        $this->expectException(Exception::class);

        $bank = new Bank();

        $customer = new Customer(CustomerType::Personal->name, 'Shez Azr');
        $bank->addCustomer($customer);

        $customer = new Customer(CustomerType::Personal->name, 'Shez Azr');
        $bank->addCustomer($customer);

        $this->assertCount(1, $bank->getCustomers());
    }

    public function test_that_i_can_create_whole_flow(): void
    {
        $bank = new Bank();

        $customer = new Customer(CustomerType::Personal->name, 'Shez Azr');

        // @todo cust can only have one type of each type.
        $account = new Account(AccountType::Current->name);
        $customer->addAccounts($account);

        $transaction = new Transaction(TransactionType::Topup->name, 200, 'ref');
        $account->addTransaction($transaction);
        $this->assertEquals(200, $account->getBalance());

        $transaction = new Transaction(TransactionType::Withdraw->name, -10, 'ref');
        $account->addTransaction($transaction);
        $this->assertEquals(190, $account->getBalance());
        $this->assertCount(2, $account->getTransactions());

        $account2 = new Account(AccountType::Saving->name);
        $customer->addAccounts($account2);

        // @todo how to do a transfer between accounts?

        $this->assertCount(2, $customer->getAccounts());

        // @todo problem with this is now if we add another account to cust
        // bank customer array will need to be replaced..
        $bank->addCustomer($customer);

        $customer2 = new Customer(CustomerType::Business->name, 'Raz Khan');

        $account3 = new Account(AccountType::Saving->name);
        $customer2->addAccounts($account3);

        $bank->addCustomer($customer2);

        $this->assertCount(3, $bank->getAccounts());

        $account4 = new Account(AccountType::Current->name);
        $customer2->addAccounts($account4);
        $bank->replaceCustomer($customer2);

        $this->assertCount(4, $bank->getAccounts());
    }
}
