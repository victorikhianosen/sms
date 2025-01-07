<?php

namespace App\Http\Controllers;

use App\Services\SMPPService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    /**
     * Send SMS
     */
    public function sendSms(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
            'sender' => 'required|string',
        ]);

        try {
            // Create SMPP service instance with your SMPP server details
            $smpp = new SMPPService();

            // Connect to the SMPP server
            $smpp->connect();
            $smpp->bind();

            // Send SMS
            $smpp->sendSms($validated['sender'], $validated['phone'], $validated['message']);

            // Close connection
            $smpp->close();

            return response()->json(['status' => 'success', 'message' => 'SMS sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
