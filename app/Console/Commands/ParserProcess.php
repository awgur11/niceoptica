<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParserProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'parser process';

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
        app()->call('App\Http\Controllers\ParserController@process');
    }
}
