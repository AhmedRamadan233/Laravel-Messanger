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
            ])->get();

        
            $messages = [];
            $activeChat = null;
            if ($id) {
                $activeChat = $chats->where('id', $id)->first();
                if ($activeChat) {
                    $messages = $activeChat->messages()->with('user')->paginate();
                }
            }
            if (!$activeChat) {
                // Handle the case where the chat with the given $id is not found.
                // For example, you can display an error message or redirect the user.
                session()->flash('error', 'Chat not found.');
            }
        return view('messanger', [
            'friends' => $friends,
            'chats' => $chats,
            'activeChat' => $activeChat,
            'messages' => $messages,
        ]);
    }

}
