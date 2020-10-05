<?php

namespace App\Service;


class SmsGateWay
{

    function send($msg, $phone, $sender = ""){

        if(empty($sender)){
            $from = "03590602016";
        }else{
            $from = $sender;
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.icombd.com/api/v1/campaigns/sms/1/text/single",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\"from\":\"{$from}\",\"text\":\"{$msg}\",\"to\":\"{$phone}\"}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Basic dW1hcml0OnVtYXJpdDE0OA=="
            ),
        ));
        $response = curl_exec($curl);
        print_r(curl_error($curl));
        curl_close($curl);
        return 'success';

    }
}