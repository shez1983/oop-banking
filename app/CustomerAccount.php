<?php

namespace Bank;

use Bank\Enums\AccountType;
use Bank\Exceptions\InvalidTypeException;

class CustomerAccount
{
    protected string $type;
    protected array $transactions;
    protected Customer $customer;

    public function __construct(Customer $customer, string $type)
    {
        $this->setType($type);
        $this->customer = $customer;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        if (! in_array($type, AccountType::all())) {
            throw new InvalidTypeException();
        }

        $this->type = $type;
    }
}
