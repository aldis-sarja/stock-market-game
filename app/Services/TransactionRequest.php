<?php

namespace App\Services;

use App\Models\User;
use App\Models\Stock;

class TransactionRequest
{
    private User $user;
    private Stock $stock;
    private int $amount;

    public function __construct(User $user, Stock $stock, int $amount)
    {
        $this->user = $user;
        $this->stock = $stock;
        $this->amount = $amount;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getStock(): Stock
    {
        return $this->stock;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
