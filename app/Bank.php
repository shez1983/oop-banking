<?php

namespace Bank;

class Bank
{
    protected array $customerAccounts;

    public function __construct()
    {
        //
    }

    public function addCustomerAccounts(CustomerAccount $customerAccount)
    {
        $this->customerAccounts[] = $customerAccount;
    }
}
