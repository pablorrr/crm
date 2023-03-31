<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

//pola wypelnialne
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'last_time_message',
    ];

    //relationships
//jedna konwersacja ma wiele wiadomoaci
    public function messages()
    {
        return $this->hasMany(Message::class);

        # code...
    }

//kowersacja nalezy do uzytkownika
    public function user()
    {
        return $this->belongsTo(User::class);
        # code...
    }
}
