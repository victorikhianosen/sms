<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;


class CallBackController extends Controller
{

    use HttpResponses;
    public function callback(Request $request)
    {
        Log::info('Callback received:', $request->all());
        return $this->success( $request->all(), 'Callback successfully');
    }
}
