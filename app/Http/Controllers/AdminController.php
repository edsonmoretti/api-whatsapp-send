<?php

namespace App\Http\Controllers;

use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $messagesToday = Auth::user()->messages()->whereDate('created_at', Carbon::today());
        $messagesYear = Auth::user()->messages()->whereYear('created_at', date('Y'));

        $messages = Auth::user()->messages();
        $countMessagesSent = $messages->count();

        $messages->where('status', '=', Message::STATUS_INVALID_NUMBER);
        $countMessagesInvalidNumber = $messages->count();

        return view('dashboard', [
            'messagesSentToday' => $messagesToday->count(),
            'messagesSent' => $countMessagesSent,
            'invalidNumberMessages' => $countMessagesInvalidNumber,
            'messagesYear' => $messagesYear->count(),
        ]);
    }
}
