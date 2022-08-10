<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use GuzzleHttp;

class AdminController extends Controller {

    public function broadcast(Request $request) {
        $googleAPIKey = Config::get('app.google_api_key');
        $requestData = [
            'input' => [
                'text' => $request->input('text')
            ],
            'voice' => [
                'languageCode' => 'cmn-CN',
                'name' => 'cmn-CN-Standard-D'
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
            $fileData = json_decode($response_texttospeech->getBody()->getContents(), true);
            return response("data:audio/wav;base64," . $fileData['audioContent']);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return response('');
        }
    }
}