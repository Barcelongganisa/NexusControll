<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StartWebsockify extends Command
{
    protected $signature = 'websockify:start';
    protected $description = 'Start Websockify for all registered SubPCs';

    public function handle()
    {
        $subPcs = DB::table('sub_pcs')->get();

        foreach ($subPcs as $subPc) {
            $ip = escapeshellarg($subPc->ip_address);
            $port = escapeshellarg($subPc->vnc_port);

$command = "start /B python -m websockify --verbose $port $ip:5900 --web C:\\xampp\\htdocs\\NexusControll\\noVNC";
pclose(popen($command, 'r'));

            
            $this->info("Started Websockify for $ip on port $port");
        }
    }
}
