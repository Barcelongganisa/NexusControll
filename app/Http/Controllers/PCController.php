<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPc;
use Illuminate\Support\Facades\Http;

class PCController extends Controller
{
    public function controlPC(Request $request)
    {
        $ip = $request->input('ip');
        $action = $request->input('action');

        $url = "http://$ip:5000/$action";

        $response = Http::post($url);

        return response()->json([
            'message' => $response->body()
        ]);
    }

    public function getDeviceCounts()
    {
        $subPcs = SubPc::all();
        $totalDevices = $subPcs->count();
        $onlineDevices = 0;

        foreach ($subPcs as $subPc) {
            if ($this->isPCOnline($subPc->ip_address)) {
                $onlineDevices++;
            }
        }

        return response()->json([
            'connected_devices' => $totalDevices,
            'online_devices' => $onlineDevices,
            'total_devices' => $totalDevices,
        ]);
    }

    public function updateDeviceStatus()
    {
        $subPcs = SubPc::all();

        foreach ($subPcs as $subPc) {
            $status = $this->isPCOnline($subPc->ip_address) ? 'online' : 'offline';


            if ($subPc->device_status !== $status) {
                $subPc->update(['device_status' => $status]);
            }
        }

        return response()->json(SubPc::all());
    }

    private function isPCOnline($ip)
    {
        $pingResult = shell_exec("ping -n 1 -w 100 $ip");
        return strpos($pingResult, 'Reply from') !== false;
    }
}
