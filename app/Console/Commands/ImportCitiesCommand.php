<?php

namespace App\Console\Commands;

use App\Imports\CitiesImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportCitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cities from an Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = resource_path('excel/worldcities.xlsx');
        DB::table('cities')->truncate();
        Excel::import(new CitiesImport, $file);
        $this->info('Cities import completed successfully.');
    }
}
