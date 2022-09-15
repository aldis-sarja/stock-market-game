<?php

namespace App\Services;

use App\Jobs\UpdateStockJob;
use App\Models\Stock;
use App\Repositories\StocksRepository;

class StocksLookUpService
{

    private StocksRepository $stocksRepository;

    public function __construct(StocksRepository $stocksRepository)
    {
        $this->stocksRepository = $stocksRepository;
    }

    public function getStockFullInfo(int $id): Stock
    {
        $stock = Stock::find($id);
        dispatch(new UpdateStockJob($this->stocksRepository, $stock));
        return $stock;
    }

    public function search(string $symbol)
    {
        $stock = Stock::firstWhere('symbol', $symbol);
        if (!$stock) {
            $stock = $this->stocksRepository->getStock($symbol,5);
            $stock = $this->stocksRepository->saveStock($symbol, $stock);
        }

        return $stock;
    }
}
