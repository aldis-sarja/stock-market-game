<?php

namespace App\Console\Commands;

use App\Jobs\FetchStocksDataJob;
use App\Repositories\FinnhubRepository;
use Illuminate\Console\Command;

class FirstRunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:first-run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run to fetch stocks data and save into database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new FetchStocksDataJob(new FinnhubRepository));

        return 0;
    }
}
