<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id' , 'lable'
    ];

    public function participants(){
        return $this->belongsToMany(User::class , 'participants');
    }

    public function messages(){
        return $this->hasMany(Message::class , 'conversation_id' , 'id');
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }



}
