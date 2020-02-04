<?php
require __DIR__."/../vendor/autoload.php";
$app = require __DIR__."/../bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Model\CommandTable;

/*
|--------------------------------------------------------------------------
| Base Config
|--------------------------------------------------------------------------
*/
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Taipei");
// Server 程式要能夠發送事件流必須將 Content-Type 表頭設置為 text/event-stream
header("Content-Type: text/event-stream\n\n");
// 表頭必須設置禁止瀏覽器快取網頁
header("Cache-Control: no-cache");
// 針對 Nginx 立即輸出緩衝區資料
header("X-Accel-Buffering: no");
/*
|--------------------------------------------------------------------------
| DB
|--------------------------------------------------------------------------
*/
function truncateTable()
{

};
/*
|--------------------------------------------------------------------------
| Main
|--------------------------------------------------------------------------
*/
// 設定 last id
$last_id = 0;
// 砍掉所有資料
//    truncateTable();
// 讓迴圈無限執行
while (true)
{
//    // 取得大於 last id 的資料
//    $command_list = CommandTable::where('id', '>', $last_id)->get()->toArray();
//    var_dump(count($command_list));
//    $command_list = CommandTable::where('id', '>', $last_id)->get()->toArray();
//    var_dump(count($command_list));
//    // 更新 last id
//    $last_command = end($command_list);
//    $last_id = $last_command['id'];
//
//    // 將資料編碼 json 傳送
//    echo "data: " . json_encode($last_id);
//    echo "\n\n";
//
//    // ob_flush();
//    flush();
//
//    // 控制睡眠多久再執行（秒）
//    sleep(1);
}
