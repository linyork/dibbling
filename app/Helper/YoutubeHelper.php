<?php

namespace App\Helper;

use \Sseffa\VideoApi\VideoApi;

class YoutubeHelper
{
    private $status;
    private $videoId;
    private $title;
    private $duration;
    private $seal;
    private $errMsg;


    public function paser(string $videoId)
    {
        try
        {
            // 判斷如果是網址的話就只擷取videoId
            if ( strlen($videoId) >= 12 )
            {
                parse_str(parse_url($videoId, PHP_URL_QUERY), $get);
                $videoId = $get['v'];
            }

            $detailData = \VideoApi::setType(VideoApi::YOUTUBE)
                ->setKey(\Config::get('app.google_api_key'))
                ->getVideoDetail($videoId);

            if($detailData['duration'] >= 600)
            {
                $this->errMsg = "點播播放時間過長的影片";
            }
            else
            {
                $this->videoId = $videoId;
                $this->title = $detailData['title'];
                $this->seal = $detailData['thumbnail_large'];
                $this->duration = $detailData['duration'];
                $this->status = true;
            }
        }
        catch (\Exception $e)
        {
            $this->status = false;
            $this->errMsg = "無法解析ID點播失敗";
            $this->title = "點播失敗";
        }
    }

    public function getErrMsg() : string
    {
        return $this->errMsg ?? '';
    }

    public function getVideoId() : string
    {
        return $this->videoId ?? '';
    }

    public function getTitle() : string
    {
        return $this->title ?? '';
    }

    public function getStatus() : bool
    {
        return $this->status ?? false;
    }

    public function getSeal() : string
    {
        return $this->seal ?? '';
    }

    public function getDuration() : int
    {
        return $this->duration ?? 0;
    }

}
