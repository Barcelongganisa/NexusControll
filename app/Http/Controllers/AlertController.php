<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Alert;

class AlertController extends Controller
{
    public function fetchAlerts()
    {
        try {
            // Request alerts from Flask API
            $response = Http::get('http://127.0.0.1:5000/get-alerts');

            if ($response->successful()) {
                $alerts = $response->json();

                // Optional: Store alerts in Laravel database
                foreach ($alerts as $alertData) {
                    Alert::updateOrCreate(
                        ['pc_name' => $alertData['pc_name'], 'message' => $alertData['message']],
                        ['severity' => $alertData['severity']]
                    );
                }

                return response()->json($alerts);
            }

            return response()->json(['error' => 'Failed to fetch alerts'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
