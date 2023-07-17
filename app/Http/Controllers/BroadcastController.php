<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function pusherAuth(Request $request)
    {
        $key = '3546f518a9d1b9e9eb74'; // Your Pusher app key (PUSHER_APP_KEY)
        $secret = 'aefe06844819e88dc8e9'; // Your Pusher app secret (PUSHER_APP_SECRET)
        $channel_name = $request->channel_name;
        $socket_id = $request->socket_id;
        $string_to_sign = $socket_id . ':' . $channel_name;
        $signature = hash_hmac('sha256', $string_to_sign, $secret);
        return response()->json(['auth' => $key . ':' . $signature]);
    }
}
