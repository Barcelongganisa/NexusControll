<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPc;
use Illuminate\Support\Facades\Http;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendDelayedLockCommand;




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
            'pc_name' => $subPc->ip_address,
            'action' => $action,
            'status' => $status,
            'timestamp' => now(),
        ]);

        return response()->json([
            'message' => $status === 'Success' ? $response->body() : 'Action failed'
        ]);
    }

public function setLockTimer(Request $request)
{
    $ips = $request->input('ips'); // Get multiple IPs as an array
    $hours = (int) $request->input('hours');
    $minutes = (int) $request->input('minutes');
    $seconds = (int) $request->input('seconds');

    if (!is_array($ips) || empty($ips)) {
        return response()->json(['message' => 'No PCs selected'], 400);
    }

    $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

    $responses = [];

    foreach ($ips as $ip) {
        $subPc = SubPc::where('ip_address', $ip)->first();
        if (!$subPc) {
            $responses[$ip] = 'PC not found';
            continue;
        }

        $url = "http://$ip:5000/set-timer";

        try {
            $response = Http::post($url, [
                'timer' => $totalSeconds,
                'action' => 'shutdown',
            ]);

            $status = $response->successful() ? 'Success' : 'Failed';
        } catch (\Exception $e) {
            $status = 'Error';
        }

        // Log each request properly
        Log::create([
            'pc_name' => $subPc->ip_address,
            'action' => 'set_timer',
            'status' => $status,
            'timestamp' => now(),
        ]);

        $responses[$ip] = $status;
    }

    return response()->json([
        'message' => 'Timers processed',
        'details' => $responses
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
    
        return response()->json(['message' => 'Status updated']);
    }

    public function getDeviceStatuses()
{
    $subPcs = SubPc::all(['ip_address', 'device_status']);
    return response()->json($subPcs);
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

    // Check for existing IP or Port
    $existing = SubPc::where('ip_address', $request->ip_address)
                    ->orWhere('vnc_port', $request->port)
                    ->first();

    if ($existing) {
        $duplicateField = null;
        if ($existing->ip_address === $request->ip_address) {
            $duplicateField = 'IP address';
        } elseif ($existing->vnc_port == $request->port) {
            $duplicateField = 'port';
        }

        return response()->json([
            'success' => false,
            'error' => "A PC with this $duplicateField already exists."
        ]);
    }

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


public function getNextPort()
{
    try {
        $lastPort = SubPc::max('vnc_port');
        $nextPort = $lastPort ? $lastPort + 1 : 6080;

        // Check if nextPort already exists
        while (SubPc::where('vnc_port', $nextPort)->exists()) {
            $nextPort++;
        }

        return response()->json([
            'last_port' => $lastPort,
            'next_port' => $nextPort
        ]);
    } catch (\Exception $e) {
        // Log the exception for debugging purposes
        \Log::error('Error fetching next port: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch next port'], 500);
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

    public function uploadFile(Request $request)
{
    $subPc = DB::table('sub_pcs')->where('ip_address', $request->input('sub_pc_id'))->first();

    if (!$subPc) {
        return response()->json(['error' => 'Sub-PC not found.'], 404);
    }

    $file = $request->file('file');
    $filename = $file->getClientOriginalName();
    $path = $file->getPathname();

    $uploadUrl = rtrim($subPc->ip_address, '/') . ':5000/upload';

    try {
        $response = Http::timeout(60)
            ->attach('file', fopen($path, 'r'), $filename)
            ->post($uploadUrl);

        $status = $response->successful();

        Log::create([
            'pc_name' => $subPc->ip_address,
            'action' => "File Transfer",
            'status' => $status,
            'timestamp' => now(),
        ]);

        return response()->json([
            'message' => $status ? 'File uploaded successfully.' : 'Upload failed.',
            'response' => $response->body(),
        ], $status ? 200 : 500);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function index()
{
    $subPcs = SubPC::all(); // Fetch all connected sub-PCs
    $alerts = DB::table('alerts')->latest()->take(5)->get();

    return view('dashboard', compact('subPcs', 'alerts'));
}




}


