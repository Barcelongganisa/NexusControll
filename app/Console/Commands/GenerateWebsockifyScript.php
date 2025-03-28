<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateWebsockifyScript extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:websockify-script';
    protected $description = 'Generate a batch file to start Websockify dynamically';

     public function handle()
    {
        $ip = config('websockify.ip');
        $port = config('websockify.port');

        $scriptContent = "@echo off\n";
        $scriptContent .= "cd /d " . base_path('noVNC') . "\n";
        $scriptContent .= "start python -m websockify --verbose {$port} {$ip}:5900 --web\n";

        $filePath = base_path('start_websockify.bat');
        File::put($filePath, $scriptContent);

        $this->info("Batch file generated successfully: {$filePath}");
    }
}
