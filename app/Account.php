<?php

namespace Bank;

use Bank\Enums\AccountType;
use Bank\Enums\TransactionType;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InvalidTypeException;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Account
{
    protected $topupLimit;
    protected $withDrawLimit = 200;

    protected string $type;
    protected array $transactions = [];

    public function __construct(string $type, int $topupLimit = 200)
    {
        $this->setType($type);

        $this->topupLimit = $topupLimit;
    }

    public function getBalance(): int
    {
        return array_reduce($this->transactions, function($carry, $item){
            return $carry += $item->getAmount();
        }, 0);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        if (! in_array($type, AccountType::all())) {
            throw new InvalidTypeException();
        }

        $this->type = $type;
    }

    public function addTransaction(Transaction $transaction): void
    {
        $transactions = $this->transactions;
        $transactions[] = $transaction;

        if ($transaction->getType() === TransactionType::Topup->name) {
            $todaysTrans = array_filter($transactions, function($item) {
                return $item->getDate()->isCurrentDay()
                    && $item->getType() ===  TransactionType::Topup->name;
            });

            $sum = array_reduce($todaysTrans, function($carry, $item){
                return $carry += $item->getAmount();
            }, 0);

            if ($sum > $this->topupLimit) {
                throw new InvalidAmountException('Amount exceeds topup limit');
            }
        }

        if ($transaction->getType() === TransactionType::Withdraw->name) {
            if ($this->getBalance() - abs($transaction->getAmount()) < 0 ) {
                throw new InvalidAmountException('Withdrawal exceeds Balance');
            }
        }

        $this->transactions[] = $transaction;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }
}
