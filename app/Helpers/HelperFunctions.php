<?php

namespace App\Helpers;

class HelperFunctions 
{
    public static function clarifai($img)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://api.clarifai.com/v2/models/aaa03c23b3724a16a56b629203edc62c/outputs', [
            'headers' => [
                'Authorization' => 'Key dad91c874b1b4c18b6e00f5c4d24a0b7',
                'Accept'     => 'application/json',
            ],
            'json' => [
                "inputs" => [
                    [
                        "data" => [
                            "image" =>  [
                                "url" => $img
                            ]
                        ]
                    ]
                ]
            ]
        ]);
        $body = json_decode($res->getBody());
        $lables = collect($body->outputs[0]->data->concepts)->pluck('name');
        return $lables;
    }
}