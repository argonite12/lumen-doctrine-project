<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ImportController;
use Doctrine\ORM\EntityManagerInterface;

class ImportCommand extends Command
{

    protected $signature = 'Import:get {results=10} {--country=All}';

    protected $description = 'Import data from 3rd party. Country: AU, BR, CA, CH, DE, DK, ES, FI, FR, GB, IE, IR, NL, NZ, TR, US';


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
     * @return mixed
     */
    public function handle(EntityManagerInterface $eM)
    {
        $results = $this->argument('results');
        $country = $this->option('country');
        
        $controller = new ImportController($results,$country);
        $this->line($controller->import_customer($eM));        
    }


}
