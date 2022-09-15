<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Repositories\StocksRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchStocksDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const NUMBER_OF_ATTEMPTS = 5;
    private StocksRepository $stocksRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StocksRepository $stocksRepository)
    {
        //
        $this->stocksRepository = $stocksRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $allSymbols = $this->stocksRepository->getSymbols();

        foreach ($allSymbols as $symbolRecord) {
            $symbol = $symbolRecord->symbol;
            if (!Stock::firstWhere('symbol', $symbol)) {

                $response = $this->stocksRepository->getStock($symbol, self::NUMBER_OF_ATTEMPTS);

                if ($response) {
                    $timeBeforeSevenDays = strtotime('-7 days');
                    if ($response->t > $timeBeforeSevenDays) {

                        $stock = new Stock([
                            'symbol' => $symbol,
                            'company_name' => $symbolRecord->description,
                            'current_price' => $response->c * 100,
                            'change' => $response->d,
                            'percent_change' => $response->dp,
                            'high_price' => $response->h,
                            'low_price' => $response->l,
                            'open_price' => $response->o,
                            'previous_close_price' => $response->pc,
                            'last_change_time' => $response->t
                        ]);
                        $stock->save();
                    }
                }
            }
        }
    }

}
