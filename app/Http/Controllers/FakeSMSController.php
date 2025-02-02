<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FakeSMSController extends Controller
{
    /**
     * Simulate sending an SMS.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSms(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
            'text' => 'required|string',
            'coding' => 'required|integer',
            'dlr-mask' => 'required|integer',
            'dlr-url' => 'required|url',
        ]);

        // Simulate a successful SMS sending process
        return response()->json([
            'status' => 'success',
            'message' => 'SMS sent successfully',
            'data' => [
                'username' => $validated['username'],
                'from' => $validated['from'],
                'to' => $validated['to'],
                'text' => $validated['text'],
                'dlr-url' => $validated['dlr-url'],
            ]
        ]);
    }
}
