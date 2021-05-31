<?php

namespace App\Service;


class OpenWetherApiService {

    public function makeApiRequest($url, $headers, $data=null, $method='POST')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_ENCODING,"");
        curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch,CURLOPT_TIMEOUT, 0);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch,CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, $method);

        if($method == 'POST'){
            curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $response = curl_exec($ch);

        if ($response === FALSE) {
           return ['errors' => ['message' => htmlspecialchars(curl_error($ch))]];
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (!$responseData) return ['errors' => ['message' => 'Unrecognised response from external API.']];

        return $responseData;
    }
}