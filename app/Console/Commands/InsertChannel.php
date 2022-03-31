<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertChannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:channel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一次灌好 channel 資料 like & record Table';

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
        DB::table('record')->update(['channel' => 'tw']);
        DB::table('like')->update(['channel' => 'tw']);
        return Command::SUCCESS;
    }
}
