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
        $returnJson = ['status' => 0, 'msg' => '', 'id' => '', 'title' => '',];
    
        $youtubeData = self::_get_youtube_title($videoId);
    
        if ( $youtubeData['status'] === 1 )
        {
            DB::table('list')->insert(
                [
                    'video_id' => $videoId,
                    'title' => $youtubeData['msg'],
                    'ip'    => request()->ip(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $returnJson['videoId'] = $videoId;
            $returnJson['title'] = $youtubeData['msg'];
            $returnJson['msg'] = "點播成功";
            $returnJson['status'] = 1;
        }
        else
        {
            $returnJson['msg'] = $youtubeData['msg'];
        }
        
        return response()->json($returnJson);
    }
    
    private function _get_youtube_title(string $videoId) : array
    {
        /* 取得 URL 頁面資料 */
        // 初始化 CURL & Return Data
        $result = ['status' => 0, 'msg' => '',];
        
        $ch = curl_init();
        
        // 設定 URL
        curl_setopt($ch, CURLOPT_URL, 'https://www.youtube.com/watch?v=' . $videoId);
        // 讓 curl_exec() 獲取的信息以資料流的形式返回，而不是直接輸出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 在發起連接前等待的時間，如果設置為0，則不等待
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        // 設定 CURL 最長執行的秒數
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        // 嘗試取得文件內容
        $store = curl_exec($ch);
        
        
        // 檢查文件是否正確取得
        if ( curl_errno($ch) )
        {
            $result['msg'] = "無法取得 URL 資料";
            return $result;
        }
        
        // 關閉 CURL
        curl_close($ch);
        
        
        // 解析 HTML 的 <head> 區段
        preg_match("/<head.*>(.*)<\/head>/smUi", $store, $htmlHeaders);
        if ( ! count($htmlHeaders) )
        {
            $result['msg'] = "無法解析資料中的 <head> 區段";
            return $result;
        }
        
        // 取得 <head> 中 meta 設定的編碼格式
        if ( preg_match("/<meta[^>]*http-equiv[^>]*charset=(.*)(\"|')/Ui", $htmlHeaders[1], $results) )
        {
            $charset = $results[1];
        }
        else
        {
            $charset = "None";
        }
        
        // 取得 <title> 中的文字
        if ( preg_match("/<title>(.*)<\/title>/Ui", $htmlHeaders[1], $htmlTitles) )
        {
            if ( ! count($htmlTitles) )
            {
                $result['msg'] = "無法解析 <title> 的內容";
                return $result;
            }
            
            // 將  <title> 的文字編碼格式轉成 UTF-8
            if ( $charset == "None" )
            {
                $title = $htmlTitles[1];
            }
            else
            {
                $title = iconv($charset, "UTF-8", $htmlTitles[1]);
            }
        }
        
        if ( $title === 'YouTube' )
        {
            $result['msg'] = "無法解析ID點播失敗";
            return $result;
        }
        
        $result['status'] = 1;
        $result['msg'] = $title;
        return $result;
    }
}
