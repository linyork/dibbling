<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class SwooleServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole {action?}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole';
    
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
        $action = $this->argument('action');
        switch ( $action )
        {
            case 'close':
                
                break;
            
            default:
                $this->start();
                break;
        }
    }
    
    public function start()
    {
        
        // 監聽WebSocket連結打開事件127.0.0.1
        $ws = new \swoole_websocket_server("0.0.0.0", 9501);
        
        // 監聽WebSocket連線打開事件
        $ws->on('open', function ($ws, $request)
        {
            // var_dump($request->fd, $request->get, $request->server);
            $ws->push($request->fd, "I am" . $request->fd);
        });
        
        // 監聽WebSocket消息事件
        $ws->on('message', function ($ws, $frame)
        {
            if($frame->data === 'player')
            {
                // 清空 player DB
                DB::table('player')->delete();
                
                // 寫入 DB 紀錄 player
                DB::table('player')->insert(
                    [
                        'id' => $frame->fd,
                        'ip'    => request()->ip(),
                    ]
                );
            }
            // 從 DB 取得 player 是誰
            $player = \App\PlayerTable::first();
            
            $ws->push($player['id'], $frame->data);
        });
        
        // 監聽WebSocket斷線事件
        $ws->on('close', function ($ws, $fd)
        {
            if($fd === 'player')
            {
                // 刪除 DB 紀錄 player
                $player = \App\PlayerTable::find($fd);
                $player->delete();
            }
        });
        
        $ws->start();
    }
}
