<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PCController extends Controller
{
    public function sendCommand(Request $request)
    {
        $command = $request->input('command');
        $pcId = $request->input('pc_id');

        // Send command to WebSocket server
        Http::post('http://192.168.1.17:3000', [
            'command' => $command,
            'pc_id' => $pcId,
        ]);

        return response()->json(['message' => "Command '{$command}' sent to {$pcId}"]);
    }
}
