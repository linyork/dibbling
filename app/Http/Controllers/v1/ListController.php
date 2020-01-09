<?php

namespace App\Http\Controllers\v1;

use DB;
use DateTime;
use DateInterval;
use App\Model\ListTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static $LIMIT_MIN = 8;

    public function index()
    {
        $dbResult = ListTable::where('deleted_at', '=', null)
            ->orderBy('updated_at')
            ->get();
        return response()->json($dbResult);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $videoId = $request->input('videoId');
        $returnJson = ['status' => 0, 'msg' => '', 'id' => '', 'title' => '',];
        $user_agent = $request->header('user-agent');
        
        if (preg_match("/Browser/i", $user_agent) || preg_match("/python/i", $user_agent))
        {
            $returnJson['msg'] = '加油!';
            return response()->json($returnJson);
        }
    
        $videoIdResult = ListTable::where('video_id', '=', $videoId)->first();

        if($videoIdResult)
        {
            $returnJson['msg'] = '加油!';
            return response()->json($returnJson);
        }
        
        $youtubeData = self::_get_youtube_title($videoId);
        list($dur_h, $dur_m, $dur_s) = self::_get_duration($videoId);

        if($dur_h != 0 || $dur_m > self::$LIMIT_MIN) {
            $returnJson['msg'] = '過長!';
            return response()->json($returnJson);            
        }
        
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

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $action
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $action)
    {
        if($action === 'played')
        {
            $request = ListTable::onlyTrashed()->orderBy('updated_at', 'DESC')->get();
        }
    
        if($action === 'random')
        {
            $request = ListTable::onlyTrashed()->inRandomOrder()->first();
        }
        
        return response()->json($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = ListTable::onlyTrashed()->find($id);
        
        return response()->json($data->restore());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->input('real'))
        {
            DB::table('list')->where('id', '=', $id)->delete();
            return response()->json('Real delete success.');
        } else {
            $list = ListTable::find($id);
            $list->delete();
            if ( $list->trashed() )
            {
                return response()->json('Soft delete success.');
            }
            else
            {
                return response()->json('Soft delete error.');
            }
        }
    }

    private function _get_duration(string $vid) : array
    {
        $h = 0;
        $m = 0;
        $s = 0;
        $api_base = 'https://www.googleapis.com/youtube/v3/videos?';
        $ary_param = array(
            'part' => 'contentDetails',
            'id' => $vid,
            'key' => 'AIzaSyD8dMvEMgk7T5U1VFjC9-LoRp486E2X7gQ'  // fisher's key, replace if u want
        );        

        $json = file_get_contents($api_base.http_build_query($ary_param));
        $ary_info = json_decode($json,true);
        if(isset($ary_info['items'][0])) {
            $duration = $ary_info['items'][0]['contentDetails']['duration'];

            // format dutaion
            $dt = new DateTime('@0'); // Unix epoch
            $dt->add(new DateInterval($duration));
            $str_duration = $dt->format('H:i:s');
            list($h, $m, $s) = explode(':', $str_duration);
            $h = intval($h);
            $m = intval($m);
            $s = intval($s);
        }

        return array($h, $m, $s);
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
