<?php

namespace Tests\Unit;

use Bank\Account;
use Bank\Customer;
use Bank\CustomerAccount;
use Bank\Enums\AccountType;
use Bank\Enums\CustomerType;
use Exception;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function test_that_i_can_create_a_new_customer(): void
    {
        $customer = new Customer(CustomerType::Personal->name, 'Shez');

        $this->assertTrue($customer->getName() === 'Shez');
    }

    public function test_that_i_cannot_create_a_new_customer_if_invalid_type(): void
    {
        $this->expectException(Exception::class);

        $customer = new Customer('Invalid', 'Shez');

        $this->assertFalse(is_object($customer));
    }

    public function test_that_i_can_attach_account_to_customer(): void
    {
        $account = new Account(AccountType::Saving->name);

        $customer = new Customer(CustomerType::Personal->name, 'Shez');
        $customer->addAccounts($account);

        $this->assertCount(1, $customer->getAccounts());
    }

    public function test_that_i_cannot_attach_two_accounts_of_same_type_to_customer(): void
    {
        $this->expectException(Exception::class);

        $account = new Account(AccountType::Saving->name);
        $account2 = new Account(AccountType::Saving->name);

        $customer = new Customer(CustomerType::Personal->name, 'Shez');
        $customer->addAccounts($account);

        $customer->addAccounts($account2);

        $this->assertCount(1, $customer->getAccounts());
    }
}
