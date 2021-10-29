<?php

namespace App\Helper;

class YoutubeHelper
{
    private $apiKey;
    private $status;
    private $videoId;
    private $title;
    private $duration;
    private $seal;
    private $errMsg;

    /**
     * Base Video Url
     *
     * @var String
     */
    private $baseVideoUrl = 'https://www.googleapis.com/youtube/v3/videos?id={id}&key={key}&part=snippet,contentDetails,statistics';

    private function setApiKey(string $apiKey)
    {
        $this->apiKey  = $apiKey;
    }

    private function setVideoId(string $videoId)
    {
        $this->videoId = $videoId;
    }

    public function getData($url)
    {
        $json = null;

        if(extension_loaded('curl'))
        {
            $ch = curl_init(str_replace('{id}', $this->videoId, $url));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);
        }
        else
        {
            $json = @file_get_contents(str_replace('{id}', $this->videoId, $url));
        }

        if(!$json)
        {
            throw new \Exception("Video or channel id is not found");
        }

        return json_decode($json);
    }

    public function convert_time($time)
    {
        $reference = new \DateTimeImmutable;
        $endTime = $reference->add(new \DateInterval($time));
        return $endTime->getTimestamp() - $reference->getTimestamp();
    }

    private function getVideoDetail() : array
    {

        $data = $this->getData(str_replace('{key}', $this->apiKey, $this->baseVideoUrl));

        if(isset($data->error))
        {
            throw new \Exception("Video not found");
        }
        return [
            'id'              => $data->items[0]->id,
            'title'           => $data->items[0]->snippet->title,
            'description'     => $data->items[0]->snippet->description,
            'thumbnail_small' => $data->items[0]->snippet->thumbnails->default->url,
            'thumbnail_large' => $data->items[0]->snippet->thumbnails->high->url,
            'duration'        => $this->convert_time($data->items[0]->contentDetails->duration),
            'upload_date'     => $data->items[0]->snippet->publishedAt,
            'like_count'      => isset($data->items[0]->statistics->likeCount) ? $data->items[0]->statistics->likeCount : 0,
            'view_count'      => isset($data->items[0]->statistics->viewCount) ? $data->items[0]->statistics->viewCount : 0,
            'comment_count'   => isset($data->items[0]->statistics->commentCount) ? $data->items[0]->statistics->commentCount : 0,
            'uploader'        => $data->items[0]->snippet->channelTitle
        ];
    }

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
            $this->setApiKey( \Config::get('app.google_api_key'));
            $this->setVideoId( $videoId);
            $detailData = $this->getVideoDetail();

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
            $this->errMsg = $e->getMessage();
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
