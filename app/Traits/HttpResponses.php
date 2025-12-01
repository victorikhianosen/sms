<?php

namespace App\Traits;



trait HttpResponses
{
 public function success($message = null, $data = null, $code = 200)
{
    if (is_string($data) && $message === null) {
        return response()->json([
            'status'  => 'success',
            'message' => $data,
        ], $code);
    }
    $response = [
        'status'  => 'success',
        'message' => $message,
    ];

    if (!is_null($data)) {
        $response['data'] = $data;
    }

    return response()->json($response, $code);
}


    public function error($message, $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
