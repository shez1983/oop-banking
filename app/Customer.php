<?php

namespace Bank;

use Bank\Enums\CustomerType;
use Bank\Exceptions\InvalidTypeException;

class Customer
{
    protected string $type; // Personal / Business
    protected string $name;

    // address, dob, phone, email etc but its fine for now

    public function __construct(string $type, string $name)
    {
        $this->setType($type);

        // todo cant have cust with same name
        $this->setName($name);
    }

    public function setType(string $type): void {
        if (! in_array($type, CustomerType::all())) {
            throw new InvalidTypeException();
        }

        $this->type = $type;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }
}
