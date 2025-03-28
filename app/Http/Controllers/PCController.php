<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPc;
use Illuminate\Support\Facades\Http;
use App\Models\Log;


class PCController extends Controller
{
    public function controlPC(Request $request)
    {
        $ip = $request->input('ip');
        $action = $request->input('action');

        $subPc = SubPc::where('ip_address', $ip)->first();

        if (!$subPc) {
            return response()->json(['message' => 'PC not found'], 404);
        }

        $url = "http://$ip:5000/$action";

        try {
            $response = Http::post($url);
            $status = $response->successful() ? 'Success' : 'Failed';
        } catch (\Exception $e) {
            $status = 'Error';
        }

        // Store the log
        Log::create([
            'pc_name'  => $subPc->pc_name,
            'action'   => $action,
            'status'   => $status,
            'timestamp' => now(),
        ]);

        return response()->json([
            'message' => $status === 'Success' ? $response->body() : 'Action failed'
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

    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip',
            'port' => 'required|integer'
        ]);

        try {
            // Add new PC to the database
            $subPc = SubPc::create([
                'ip_address' => $request->ip_address,
                'vnc_port' => $request->port
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    public function showLogs()
    {
        $logs = Log::orderBy('timestamp', 'desc')->get();
        return view('dashboard', compact('logs')); 
    }

    public function getProcesses(Request $request)
    {
        $ip = $request->input('ip');

        // Simulating fetching processes remotely
        // In a real case, you'd connect to the remote PC (via SSH or another method)
        if (PHP_OS_FAMILY === 'Windows') {
            // Get running processes on Windows
            $output = shell_exec('tasklist');
        } else {
            // Get running processes on Linux/Mac
            $output = shell_exec('ps -eo comm');
        }

        if (!$output) {
            return response()->json(['message' => 'Failed to fetch processes.'], 500);
        }

        // Convert output into an array of processes
        $processes = explode("\n", trim($output));

        return response()->json(['processes' => $processes]);
    }
}
