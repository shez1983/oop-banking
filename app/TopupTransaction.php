<?php

namespace Bank;

use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InvalidTypeException;
use Carbon\Carbon;

class TopupTransaction extends Transaction
{
    public function __construct(int $amount, string $reference)
    {
        parent::__construct($amount, $reference);

        $this->setType();
    }

    public function setType(): void
    {
        $this->type = TransactionType::Topup->name;
    }

    public function setAmount(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidAmountException('Cannot be 0 or below');
        }

       parent::setAmount($amount);
    }
}
