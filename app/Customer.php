<?php

namespace Bank;

use Bank\Enums\CustomerType;
use Bank\Exceptions\InvalidTypeException;
use Exception;

class Customer
{
    protected string $type; // Personal / Business
    protected string $name;
    protected array $accounts = [];

    // address, dob, phone, email etc but its fine for now

    public function __construct(string $type, string $name)
    {
        $this->setType($type);
        $this->setName($name);
    }

    public function addAccounts(Account $newAccount)
    {
        foreach ($this->accounts as $account) {
            if ($account->getType() === $newAccount->getType()) {
                throw new Exception('Already have same account');
            }
        }

        $this->accounts[] = $newAccount;
    }

    public function getAccounts(): array
    {
        return $this->accounts;
    }

    public function setType(string $type): void
    {
        if (! in_array($type, CustomerType::all())) {
            throw new InvalidTypeException();
        }

        $this->type = $type;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
