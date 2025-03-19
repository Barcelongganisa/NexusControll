<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DeviceController extends Controller
{
    public function getDeviceStats()
    {
        try {
            Log::info("Fetching device stats from Node.js...");

            // Fetch connected devices from Node.js
            $nodeResponse = Http::get('http://127.0.0.1:3000/api/connected-pcs');

            if ($nodeResponse->failed()) {
                throw new \Exception("Failed to fetch devices from Node.js");
            }

            $devices = $nodeResponse->json(); // Convert response to array

            // Count devices based on status
            $connected = count($devices);
            $online = count(array_filter($devices, fn($pc) => $pc['status'] === 'Online'));
            $total = $connected; // Since we only track connected devices

            Log::info("Device stats: Connected=$connected, Online=$online, Total=$total");

            return response()->json([
                'connected' => $connected,
                'online'    => $online,
                'total'     => $total,
            ]);
        } catch (\Exception $e) {
            Log::error("Device stats error: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}



