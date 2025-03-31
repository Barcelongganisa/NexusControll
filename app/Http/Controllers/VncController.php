<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPc;
use App\Models\Log;
use App\Models\Alert;
use Illuminate\Support\Facades\DB;

class VncController extends Controller
{
    public function index()
    {
        $subPcs = SubPc::all();
        $logs = Log::all();
        $alerts = Alert::latest()->take(5)->get(); 

        return view('dashboard', compact('subPcs', 'logs', 'alerts'));
    }
}
