<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        return view('message', [
            'messages' => Auth::user()->messages()->orderBy('created_at', 'desc')
        ]);
    }
}
