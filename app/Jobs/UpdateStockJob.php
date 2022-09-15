<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Repositories\StocksRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private StocksRepository $stocksRepository;
    private Stock $stock;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StocksRepository $stocksRepository, Stock $stock)
    {

        $this->stocksRepository = $stocksRepository;
        $this->stock = $stock;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->stocksRepository->updateStock($this->stock);
    }
}
