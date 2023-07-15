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
    public function index()
    {
        $user = Auth::user();
        $friends = User::where('id', '<>', $user->id)
            ->orderBy('name' )
            ->paginate();  
            
            
            $chats = $user->conversations()
    ->with([
        'lastMessage',
        'participants' => function ($builder) use ($user) {
            $builder->where('users.id', '<>', $user->id);
        }
    ])
    ->get();

       
       
                // $chats = Conversation::whereHas('participants', function ($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })
        // ->with([
        //     'lastMessage', 
        //     'participants' => function ($builder) use ($user) {
        //         $builder->where('users.id', '<>', $user->id);
        //     },
        //     'participants.user' // Load the 'user' relationship on the 'participants' model
        // ])
        // ->latest('last_message_id')
        // ->get();
    
// return $chats;
        return view('messanger', 
        [
            'friends' => $friends,
            'chats' => $chats
        ]);
    }
}
