<?php

namespace App\Http\Controllers;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\TextToSpeechGrpcClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use GuzzleHttp;

class AdminInterface extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        $googleAPIKey = \Config::get('app.google_api_key');
//        $articleText = '好';
//
//        $client = new GuzzleHttp\Client();
//
//        $requestData = [
//            'input' =>[
//                'text' => $articleText
//            ],
//            'voice' => [
//                'languageCode' => 'cmn-CN',
//                'name' => 'cmn-CN-Wavenet-D'
//            ],
//            'audioConfig' => [
//                'audioEncoding' => 'MP3',
//                'pitch' => 0.00,
//                'speakingRate' => 1.00
//            ]
//        ];
//
//
//        try {
//            $response = $client->request('POST', 'https://texttospeech.googleapis.com/v1beta1/text:synthesize?key=' . $googleAPIKey, [
//                'json' => $requestData
//            ]);
//
//        } catch (Exception $e) {
//            die('Something went wrong: ' . $e->getMessage());
//        }
//
//
//        $fileData = json_decode($response->getBody()->getContents(), true);
//        file_put_contents('tts.mp3', base64_decode($fileData['audioContent']));

        return view('admin_interface');
    }
}
