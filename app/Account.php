<?php

namespace Bank;

class Account
{
    protected array $accounts;

    public function __construct(Account $account)
    {
        $this->accounts[] = $account;
    }
}
