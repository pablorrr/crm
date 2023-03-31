<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    use HasFactory;

    protected $fillable=[
        'sender_id',
        'receiver_id',
        'last_time_message',
        'conversation_id',
        'read',
        'body',
    ];

//message prszynalezy do conversation
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);

    }
//message przynalezy do uzytkownika
    public function user( )
    {
        return $this->belongsTo(User::class ,'sender_id');

    }

}
