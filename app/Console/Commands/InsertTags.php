<?php

namespace App\Console\Commands;

use App\Helpers\YoutubeHelper;
use App\Model\TagModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新增 tags 資料';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(YoutubeHelper $youtubeHelper)
    {
        $this->youtubeHelper = $youtubeHelper;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(DB::table('list')->get() as $youtube)
        {
            $this->youtubeHelper->parser($youtube->video_id);
            foreach($this->youtubeHelper->getTags() as $tag)
            {
                $tagModel = (new TagModel());
                $tagModel->list_id = $youtube->id;
                $tagModel->tag = $tag;
                $tagModel->save();
            }
            sleep(1);
        }
        return Command::SUCCESS;
    }
}
