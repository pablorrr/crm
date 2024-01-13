<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    use HasFactory;

    /**
     * @var mixed
     */

    protected $fillable=[
        'sender_id',
        'receiver_id',
        'last_time_message',
        'conversation_id',
        'read',
        'body',
    ];




    public function user( )
    {
        return $this->belongsTo(User::class ,'sender_id');
        # code...
    }

}