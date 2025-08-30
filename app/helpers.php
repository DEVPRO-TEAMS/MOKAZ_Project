<?php

use Illuminate\Support\Facades\Http;


function RefgenerateCode($table,$init,$key)
{
    $latest = $table::latest()->first();
    if (! $latest) {
        return $init.'-00001';
    }

    $string = preg_replace("/[^0-9\.]/", '', $latest->$key);

    return $init.'-' . sprintf('%05d',$string+1);
}
function Refgenerate($table,$init,$key)
{
    $latest = $table::latest()->first();
    if (! $latest) {
        return $init.'-00001';
    }

    $string = preg_replace("/[^0-9\.]/", '', $latest->$key);

    return $init.'-' . sprintf('%05d',$string+1);
}

if (!function_exists('sendSms')) {
    function sendSms($to, $message)
    {
        $apiUrl = config('services.sms.url');
        $apiKey = config('services.sms.key');

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
            'Accept'        => 'application/json',
        ])->post($apiUrl, [
            'from'    => 'jsbeyci',
            'to'      => $to,
            'content' => $message,
        ]);

        return $response->json();
    }
}

