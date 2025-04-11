<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http; // ✅ Add this to use Http facade
use Illuminate\Support\Facades\Log;

class SendDelayedLockCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ip;

    /**
     * Create a new job instance.
     *
     * @param string $ip
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $url = "http://{$this->ip}:5000/lock"; // Flask endpoint
            $response = Http::post($url);
    
            if ($response->failed()) {
                Log::error("Lock failed for {$this->ip}: " . $response->body());
            } else {
                Log::info("Lock command sent successfully to {$this->ip}");
            }
        } catch (\Exception $e) {
            Log::error("Lock error for {$this->ip}: " . $e->getMessage());
        }
    }
}   

