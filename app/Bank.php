<?php

namespace Bank;

use Exception;

class Bank
{
    protected array $customers = [];

    public function __construct()
    {
        //
    }

    public function getCustomerIndex(Customer $customer): int|false
    {
        $key = false;

        for($i = 0; $i < count($this->customers); $i++) {
             if ($this->customers[$i]->getName() === $customer->getName()) {
                 $key = $i;
                 break;
             }
        }

        return $key;
    }

    public function addCustomer(Customer $customer)
    {
        $key = $this->getCustomerIndex($customer);

        if ($key !== false) {
            throw new Exception('');
        }

        $this->customers[] = $customer;
    }

    public function replaceCustomer(Customer $customer)
    {
        $key = $this->getCustomerIndex($customer);

        if ($key === false) {
            throw new Exception('');
        }

        unset($this->customers[$key]);
        $this->customers[] = $customer;
    }

    public function getAccounts(): array
    {
        $totalAccounts = [];

        foreach ($this->customers as $customer) {
            $totalAccounts = array_merge($totalAccounts, $customer->getAccounts());
        }

        return $totalAccounts;
    }

    public function getCustomers(): array
    {
        return $this->customers;
    }
}
