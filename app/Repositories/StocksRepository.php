<?php

namespace App\Repositories;

use App\Models\Stock;

interface StocksRepository
{
    public function updateStock(Stock $stock): void;

    public function getNews(string $category, $payload): ?array;

    public function getStock(string $symbol, int $numberOfAttempts);

    public function getSymbols(): ?array;

    public function saveStock($symbol, $data);
}
