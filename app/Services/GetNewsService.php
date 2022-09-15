<?php

namespace App\Services;

use App\Repositories\StocksRepository;

class GetNewsService
{

    private StocksRepository $stocksRepository;

    public function __construct(StocksRepository $stocksRepository)
    {
        $this->stocksRepository = $stocksRepository;
    }

    public function get(string $category, $payload)
    {
        return $this->stocksRepository->getNews($category, $payload);
    }

}
