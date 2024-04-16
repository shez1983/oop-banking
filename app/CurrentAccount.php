<?php

namespace Bank;

use Bank\Enums\AccountType;
use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InvalidTypeException;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class CurrentAccount extends Account
{
    public function __construct(int $topupLimit = 200)
    {
        parent::__construct($topupLimit);

        $this->setType();
    }

    public function setType(): void
    {
        $this->type = AccountType::Current->name;
    }
}
