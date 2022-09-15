<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\Sale;

class PurchasesHistoryRecord
{
    private array $purchases = [];
    private array $sales = [];

    public function __construct($purchases, $sales)
    {

        foreach ($purchases as $purchase) {
            $this->addPurchase($purchase);
        }

        foreach ($sales as $sale) {
            $this->addSale($sale);
        }

    }

    private function addPurchase(Purchase $purchase): void
    {
        $this->purchases[] = $purchase;
    }

    private function addSale(Sale $sale): void
    {
        $this->sales[] = $sale;
    }

    public function getPurchases(): array
    {
        return $this->purchases;
    }

    public function getSales(): array
    {
        return $this->sales;
    }
}
