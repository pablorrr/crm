<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $receiver;


    public function __construct($user, $message, $receiver)
    {
        $this->user = $user;
        $this->message = $message;
        $this->receiver = $receiver;
    }

    public function broadcastWith()
    {
        return [
            'user' => $this->user,
            'message' => $this->message,
            'receiver' => $this->receiver
        ];

    }


    public function broadcastOn()
    {
        error_log($this->message);
        error_log($this->receiver);
        return new PrivateChannel('chat.'.$this->receiver);
    }


}
