<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;

use App\Models\Chat\Conversation;
use App\Models\Chat\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SendMessage extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $body;
    public $createdMessage;
    //tablica ta zawiera z nazwy metod sluchaczy
    protected $listeners = ['updateSendMessage', 'dispatchMessageSent','resetComponent'];


    public function resetComponent()
    {

  $this->selectedConversation= null;
  $this->receiverInstance= null;

        # code...
    }

    function updateSendMessage(Conversation $conversation, User $receiver)
    {

        //  dd($conversation,$receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
        # code...
    }



//metoda okreslona w action attr w formularzu
    public function sendMessage()
    {//njprwd domylsne  czyszczenie tresci msg
        if ($this->body == null) {
            return null;
        }
//zapis wysylanej wiadomosci do tabeli messeges
        $this->createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiverInstance->id,
            'body' => $this->body,

        ]);

        $this->selectedConversation->last_time_message = $this->createdMessage->created_at;
        $this->selectedConversation->save();
        //njpwrd emsja zdrzenia pushmessege do chatbox blade z arg o wrtosci id wyslanej woadomsci
        $this->emitTo('chat.chatbox', 'pushMessage', $this->createdMessage->id);


        //reshresh coversation list
        $this->emitTo('chat.chat-list', 'refresh');
        $this->reset('body');


        //powiazanie z channels dla pusher events broadcasting, patrz linia 77
        $this->emitSelf('dispatchMessageSent');
        // dd($this->body);
        # code..
    }


//njpwrd metoda obslugujaca wysylanie wiadomosci
    public function dispatchMessageSent()
    {

        broadcast(new MessageSent(Auth()->user(), $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
        # code...
    }
    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
