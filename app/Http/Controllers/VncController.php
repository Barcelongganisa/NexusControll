<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPc;
use App\Models\Log;

class VncController extends Controller
{
    public function index()
{
    $subPcs = SubPc::all();
    $logs = Log::all(); 
    return view('dashboard', compact('subPcs', 'logs'));
}

}
