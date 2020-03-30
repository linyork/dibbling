<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\LikeTable;
use App\Model\ListTable;
use App\Model\RecordTable;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp;

class AdminController extends Controller
{
    public function deleteUser(string $deleteUserId)
    {
        try
        {
            \DB::beginTransaction();
            // delete list
            \DB::table(with(new ListTable)->getTable())
                ->whereIn('id', function ($query) use ($deleteUserId)
                {
                    $query->select('list_id')
                        ->from(with(new RecordTable)->getTable())
                        ->where('user_id', $deleteUserId)
                        ->where('record_type', RecordTable::DIBBLING);
                }
            )->delete();
            // delete record
            \DB::table(with(new RecordTable)->getTable())->where('user_id', $deleteUserId)->delete();
            // delete like
            \DB::table(with(new LikeTable)->getTable())->where('user_id', $deleteUserId)->delete();
            // delete user
            \DB::table(with(new User)->getTable())->where('id', $deleteUserId)->delete();
            \DB::commit();
        }
        catch (\Exception $e)
        {
            \DB::rollback();
            $deleteUserId = 0;
        }
        return response($deleteUserId);
    }

    public function broadcast(Request $request) {
        $googleAPIKey = \Config::get('app.google_api_key');
        $requestData = [
            'input' =>[
                'text' => $request->post('text')
            ],
            'voice' => [
                'languageCode' => 'cmn-CN',
                'name' => 'cmn-CN-Wavenet-D'
            ],
            'audioConfig' => [
                'audioEncoding' => 'MP3',
                'pitch' => 0.00,
                'speakingRate' => 1.00
            ]
        ];


        try {
            $client = new GuzzleHttp\Client();
            $response_texttospeech = $client->request('POST', 'https://texttospeech.googleapis.com/v1beta1/text:synthesize?key=' . $googleAPIKey, [
                'json' => $requestData
            ]);
            $response = 1;

        } catch (Exception $e) {
            $errorMessage = 'Something went wrong: ' . $e->getMessage();
            $response = 0;
        }


        $fileData = json_decode($response_texttospeech->getBody()->getContents(), true);
        file_put_contents('broadcast.mp3', base64_decode($fileData['audioContent']));
        return response($response);
    }
}
