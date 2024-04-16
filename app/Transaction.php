<?php

namespace Bank;

use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InvalidTypeException;
use Carbon\Carbon;

class Transaction
{
    protected string $type; // withdraw, top up, transfer
    protected int $amount;
    protected string $reference;
    protected Carbon $date;

    // could add a label to group trans together ie finance, shopping etc

    public function __construct(int $amount, string $reference)
    {
        $this->setAmount($amount);
        $this->setReference($reference);

        $this->date = now();
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }
}
