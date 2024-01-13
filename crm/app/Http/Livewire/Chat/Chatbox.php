<?php

namespace App\Http\Livewire\Chat;

use App\Models\Chat\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chatbox extends Component
{
    // protected $listeners = ['pushMessage'];//njprwd brak roznicy z getlisteners - dziala tak samo

    public $test;
    public $messages;
    public $users;
    public $receiverId;
    protected $listeners = [];
    public $conversations;
    public $receiverInstance;
    public $height;

    public function getListeners()
    {
        $auth_id = Auth::id();



        //ver bez pushe msg
        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived', 'getReceiverId',
            'loadmore', 'refreshComponent' => '$refresh','getBottom','updateHeight'
        ];
    }


    /**
     * wszzytskie metody ponizej odpalaja sie gdy odpaliny jest event do ktorego sa przypisane!!!
     * sam event odpala sie za pomoca bradcast ktory z kolei odpala sie na jakas interakcje usera z przegadarka np click.
     *
     */

    public function getReceiverId($Id)
    {
        $this->receiverId = $Id;
        return $this->receiverId;
    }

    public function getBottom()
    {
      //  dd('works get bootom blocked row');
        $this->dispatchBrowserEvent('rowChatToBottom');
    }


    public function broadcastedMessageReceived($event)
    {

        $this->emitSelf('refreshComponent');
        //   dd($event); //zwroci  - array:1 [▼
        // "message" => "test message"]

    }

    function loadmore()
    {
        dd('test listener loadmore -OK');

        # code...
    }


// function updateHeight($height)
//    {
//
//        // dd($height);
//        $this->height = 123;
//
//        # code...
//    }


    public function render()
    {
        //nie stosowac mount bo $this->receiver jest tam nie osiagalny
        $this->receiverInstance = User::where('id', $this->receiverId)->get();

//pokaz wszytskie wiadomosci jakie ortrzymalem - Message::where('receiver_id', auth()->user()->id)
//pokaz wszytskie wiadmosci jaiie wyslalem - ->where('sender_id', auth()->user()->id)->get();
        $this->messages = Message::where('receiver_id', auth()->user()->id)//jesli zalogowany otrzymuje msg
        ->where('sender_id', $this->receiverId)//pokaz msg tylko od tego ktrego klikenlem
        ->orWhere('receiver_id', $this->receiverId)//pokaz msg tylko od tego ktrego klikenlem
        ->where('sender_id', auth()->user()->id)->get();//jesli zalogoweany wysyla msg}

        return view('livewire.chat.chatbox');
    }
}
