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

    public function __construct(string $type, int $amount, string $reference)
    {
        $this->setType($type);
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

    public function setType(string $type): void
    {
        if (! in_array($type, TransactionType::all())) {
            throw new InvalidTypeException();
        }

        $this->type = $type;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        if ($this->type === TransactionType::Topup->name && $amount <= 0) {
            throw new InvalidAmountException('Cannot be 0 or below');
        }

        if ($this->type === TransactionType::Withdraw->name && $amount >= 0) {
            throw new InvalidAmountException('Cannot be 0 or above');
        }

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
