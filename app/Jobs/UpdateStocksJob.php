<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Repositories\StocksRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateStocksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private StocksRepository $stocksRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StocksRepository $stocksRepository)
    {
        $this->stocksRepository = $stocksRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stocks = Stock::whereIn('id', DB::table('stock_portfolios')->select('stock_id'))->get();
        foreach ($stocks as $stock) {
            $this->stocksRepository->updateStock($stock);
        }
    }
}
