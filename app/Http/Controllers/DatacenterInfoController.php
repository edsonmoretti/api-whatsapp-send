<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatacenterInfoController extends Controller
{
    public function index()
    {
        return view('datacenterinfo', [
            'datacenterinfos' => Auth::user()->datacenterInfos()->orderBy('created_at', 'desc')
        ]);
    }
}
