<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class dibbling extends Controller
{
    public function index()
    {
        return view('dibbling');
    }
    
    public function dibbling(string $videoId)
    {
        /* 取得 URL 頁面資料 */
        // 初始化 CURL & Return Data
        $returnJson = [
            'status' => 0,
            'msg' => '',
            'id' => '',
            'title' => '',
        ];
        $ch = curl_init();
    
        // 設定 URL
        curl_setopt($ch, CURLOPT_URL, 'https://www.youtube.com/watch?v='.$videoId);
        // 讓 curl_exec() 獲取的信息以資料流的形式返回，而不是直接輸出。
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        // 在發起連接前等待的時間，如果設置為0，則不等待
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
        // 設定 CURL 最長執行的秒數
        curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
    
        // 嘗試取得文件內容
        $store = curl_exec ($ch);
    
    
        // 檢查文件是否正確取得
        if (curl_errno($ch)){
            $returnJson['msg'] = "無法取得 URL 資料";
            return response()->json($returnJson);
            exit;
        }
    
        // 關閉 CURL
        curl_close($ch);
    
    
        // 解析 HTML 的 <head> 區段
        preg_match("/<head.*>(.*)<\/head>/smUi",$store, $htmlHeaders);
        if(!count($htmlHeaders)){
            $returnJson['msg'] = "無法解析資料中的 <head> 區段";
            return response()->json($returnJson);
            exit;
        }
    
        // 取得 <head> 中 meta 設定的編碼格式
        if(preg_match("/<meta[^>]*http-equiv[^>]*charset=(.*)(\"|')/Ui",$htmlHeaders[1], $results)){
            $charset =  $results[1];
        }else{
            $charset = "None";
        }
    
        // 取得 <title> 中的文字
        if(preg_match("/<title>(.*)<\/title>/Ui",$htmlHeaders[1], $htmlTitles)){
            if(!count($htmlTitles)){
                $returnJson['msg'] = "無法解析 <title> 的內容";
                return response()->json($returnJson);
                exit;
            }
        
            // 將  <title> 的文字編碼格式轉成 UTF-8
            if($charset == "None"){
                $title=$htmlTitles[1];
            }else{
                $title=iconv($charset, "UTF-8", $htmlTitles[1]);
            }
        }
        
        if($title === 'YouTube')
        {
            $returnJson['msg'] = "無法解析ID點播失敗";
            return response()->json($returnJson);
        }
        
        $dbResult = DB::table('list')->insert(
            [
                'video_id' => $videoId,
                'title' => $title,
                'ip'    => request()->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        
        $returnJson['videoId'] = $videoId;
        $returnJson['title'] = $title;
        $returnJson['msg'] = "點播成功";
        $returnJson['status'] = 1;
        
        return response()->json($returnJson);
    }
}
