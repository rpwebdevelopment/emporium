<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DateController;

class GenerateCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Payment Dates CSV and saves to storage/app/csv';

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
     * @throws \Exception
     */
    public function handle()
    {
        $csv = new DateController();
        $csv->buildPaymentDatesArray();
    }
}
