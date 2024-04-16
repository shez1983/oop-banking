<?php

namespace Bank;

use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InvalidTypeException;
use Carbon\Carbon;

class WithdrawTransaction extends Transaction
{
    public function __construct(int $amount, string $reference)
    {
        parent::__construct($amount, $reference);

        $this->setType();
    }

    public function setType(): void
    {
        $this->type = TransactionType::Withdraw->name;
    }

    public function setAmount(int $amount): void
    {
        if ($amount >= 0) {
            throw new InvalidAmountException('Cannot be 0 or above');
        }

       parent::setAmount($amount);
    }
}
