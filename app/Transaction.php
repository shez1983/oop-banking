<?php

namespace Bank;

use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidTypeException;

class Transaction
{
    protected string $type; // withdraw, top up, transfer
    protected int $amount;
    protected string $reference;

    // could add a label to group trans together ie finance, shopping etc

    public function __construct(string $type, int $amount, string $reference)
    {
        $this->setType($type);
        $this->setAmount($amount);
        $this->setReference($reference);
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        if (! in_array($type, TransactionType::all())) {
            throw new InvalidTypeException();
        }

        $this->type = $type;
    }

    public function getAmount(): int {
        return $this->amount;
    }

    public function setAmount(int $amount): void {

        if ($amount <= 0) {
            throw new InvalidTypeException('Cannot be 0 or below');
        }

        // there could be daily transaction limit ie cant withdraw more than 300 per daily
        // or top up more than 1000 per day..
        // but that is before transaction is created?

        $this->amount = $amount;
    }

    public function getReference(): string {
        return $this->reference;
    }

    public function setReference(string $reference): void {
        $this->type = $reference;
    }
}
