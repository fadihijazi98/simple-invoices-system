<?php


namespace App\helpers;


class AppHelper
{
    public function getResponseData($response, $data)
    {
        $responseContent = $response->getContent();

        return
            json_decode($responseContent)
                ->$data;
    }
}
