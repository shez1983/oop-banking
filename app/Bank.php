<?php

namespace Bank;

class Bank
{
    protected array $accounts;

    public function __construct()
    {
        //
    }

    public function addCustomerAccounts(Account $account)
    {
        $this->accounts[] = $account;
    }
}
