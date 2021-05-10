<?php

namespace App\Console\Commands;

use App\Http\Controllers\OilPriceController;
use Illuminate\Console\Command;

class LoadOilPricesFromUri extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buzzoole:loadoilprices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load oil prices from URI and populate DB';

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
        OilPriceController::fillDatabaseFromUri();
        return 0;
    }
}
