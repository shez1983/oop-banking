<?php

namespace Tests\Unit;

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
}
