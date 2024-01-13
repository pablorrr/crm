<?php 
namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Chat\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class SendMessage extends Component
{
    public $body;
    public $test;
    public $receiver;
    public $createdMessage;


    protected $listeners = ['dispatchMessageSent', 'getReceiverId'];

//TA METODA wywoluje sie niejawnie podczas ladowania eventu poprzez bracasdt


    public function getReceiverId($Id)
    {
        $this->receiver = $Id;
        return $this->receiver;
    }

    public function sendMessage()
    {
        if ($this->body == null) {
            return null;
        }
        // dd($this->receiver);
        if (!$this->receiver) {
            echo '<script>alert("select a user!!!")</script>';
          // return;
        }
        $this->createdMessage = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiver,
            'body' => $this->body,
            'read' => 1,
        ]);

     //   $this->emitTo('chat.chatbox', 'pushMessage', 'emitTo-OK');
        $this->reset('body');//reset wbudowane w component, tutaj resetuje pole body
        $this->emitSelf('dispatchMessageSent');
        $this->emitTo( 'chat.chatbox','refreshComponent');
        $this->emitTo( 'chat.chatbox','getBottom');


        # code..
    }


    public function dispatchMessageSent()
    {
        // $this->body = 'test message OK, emitSelf OK';
        //  $this->receiver = 2;//1 numer id pierwszego usera z tabeli
        broadcast(new MessageSent(Auth::id(), $this->createdMessage, $this->receiver));
        //dd($this->body);
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}