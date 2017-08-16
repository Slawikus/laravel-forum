<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Thread $thread)
    {
        $reply = Reply::make(['body' => $request->body, 'user_id' => Auth::id()]);
        $thread->addReply($reply);

        return back();
    }
}
