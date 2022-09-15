<?php

namespace App\Console\Commands;

use App\Jobs\UpdateStocksJob;
use App\Models\Stock;
use App\Repositories\FinnhubRepository;
use Illuminate\Console\Command;
use PHPUnit\Runner\Extension\PharLoader;

class UpdateStocksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-stocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stocks';

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
        dispatch(new UpdateStocksJob(new FinnhubRepository));

        return 0;
    }

}
