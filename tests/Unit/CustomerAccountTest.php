<?php

namespace Tests\Unit;

use Bank\Customer;
use Bank\CustomerAccount;
use Bank\Enums\AccountType;
use Bank\Enums\CustomerType;
use Exception;
use PHPUnit\Framework\TestCase;

class CustomerAccountTest extends TestCase
{
    public function test_that_i_can_create_a_new_account(): void
    {
        $customer = new Customer(CustomerType::Personal->name, 'Shez');

        $account = new CustomerAccount($customer, AccountType::Saving->name);

        $this->assertTrue($account->getType() === 'Saving');
    }

    public function test_that_i_cannot_create_a_new_account_if_invalid_type(): void
    {
        $this->expectException(Exception::class);

        $customer = new Customer(CustomerType::Personal->name, 'Shez');

        $account = new CustomerAccount($customer, 'Invalid');

        $this->assertFalse(is_object($account));
    }
}
