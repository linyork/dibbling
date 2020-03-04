<?php

namespace App\Helper;

use \Sseffa\VideoApi\VideoApi;

class YoutubeHelper
{
    private $apiKey = 'AIzaSyBLWdR9mE4HjzKz_x4vjHH7nrgI1DTPDE4';
    private $status;
    private $title;
    private $duration;
    private $seal;
    private $errMsg;


    public function paser(string $videoId)
    {
        try
        {
            $detailData = \VideoApi::setType(VideoApi::YOUTUBE)->setKey($this->apiKey)->getVideoDetail($videoId);

            if($detailData['duration'] >= 600)
            {
                $this->errMsg = "點播播放時間過長的影片";
            }
            else
            {
                $this->title = $detailData['title'];
                $this->seal = $detailData['thumbnail_large'];
                $this->duration = $detailData['duration'];
                $this->status = true;
            }
        }
        catch (\Exception $e)
        {
            $this->errMsg = "無法解析ID點播失敗";
        }
    }

    public function getErrMsg() : string
    {
        return $this->errMsg ?? '';
    }

    public function getTitle() : string
    {
        return $this->title ?? '';
    }

    public function getStatus() : string
    {
        return $this->title ?? '';
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
