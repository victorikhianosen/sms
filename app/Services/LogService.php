<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;

class LogService
{
    public static function scheduleSms($message = null, array $data = [])
    {
        Log::channel('schedule_sms')->info($message, $data);
    }

    public static function payment($message = null, array $data = [])
    {
        Log::channel('payment')->info($message, $data);
    }
}
