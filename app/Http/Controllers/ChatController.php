<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LRedis;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendMessage(Request $request) {
        $redis = LRedis::connection();
        $data = ['message' => $request['message'], 'user' => $request['user']];
        $redis->publish('message', json_encode($data));
        return response()->json($data);
    }
}