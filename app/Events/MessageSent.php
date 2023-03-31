<?php

namespace App\Events;


use App\Models\Chat\Conversation;
use App\Models\Chat\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $conversation;
    public $receiver;

//DI
    public function __construct(User $user, Message $message, Conversation $conversation, User $receiver)
    {

        $this->user = $user;
        $this->message = $message;
        $this->conversation = $conversation;
        $this->receiver = $receiver;
    }

//metoda wbudowana w laravel
    public function broadcastWith()
    {

        return [
            'user_id' => $this->user->id,
            'message' => $this->message->id,
            'conversation_id' => $this->conversation->id,
            'receiver_id' => $this->receiver->id,
        ];
        # code...
    }


    /**
     * Uzyskaj kanały, na których wydarzenie powinno być transmitowane
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {//error log njpwrd przesylanie do pliku loga zadanych danych w parametrze
        error_log($this->user);
        error_log($this->receiver);
        return new PrivateChannel('chat.'.$this->receiver->id);
    }
}
