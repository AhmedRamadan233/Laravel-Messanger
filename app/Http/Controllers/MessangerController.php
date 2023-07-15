<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MessangerController extends Controller
{
    public function index($id = null)
    {
        $user = Auth::user();
        $friends = User::where('id', '<>', $user->id)
            ->orderBy('name')
            ->paginate();

        $chats = $user->conversations()
            ->with([
                'lastMessage',
                'participants' => function ($builder) use ($user) {
                    $builder->where('users.id', '<>', $user->id);
                }
            ])
            ->get();

        $messages = [];
        if ($id) {
            $chat = $chats->where('id', $id)->first();
            if ($chat) {
                $messages = $chat->messages()->with('user')->paginate();
            }
        }

        return view('messanger', [
            'friends' => $friends,
            'chats' => $chats,
            'messages' => $messages,
        ]);
    }

}
