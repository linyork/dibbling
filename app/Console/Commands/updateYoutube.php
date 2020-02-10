<?php

namespace App\Console\Commands;

use App\Helper\YoutubeHelper;
use App\Model\ListTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class updateYoutube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:youtube';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update youtube duration & seal';

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
    public function handle()
    {
        foreach (DB::table('list')->get() as $row)
        {
            $YoutubeHelper = new YoutubeHelper();
            $YoutubeHelper->paser($row->video_id);
            $thisVideo = ListTable::withTrashed()->find($row->id);
            $thisVideo->duration = $YoutubeHelper->getDuration();
            $thisVideo->seal = $YoutubeHelper->getSeal();
            $thisVideo->save();
            echo $row->title."\n";
            echo $YoutubeHelper->getSeal().":".$YoutubeHelper->getDuration()."\n";
            echo "Done.\n";
        }
        return;
    }
}
