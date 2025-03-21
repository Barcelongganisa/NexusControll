<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPc;

class VncController extends Controller
{
    public function index()
    {
        $subPcs = SubPc::all();

        return view('dashboard', compact('subPcs'));
    }
}
