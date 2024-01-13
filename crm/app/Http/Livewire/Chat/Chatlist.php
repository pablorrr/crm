<?php
namespace App\Http\Livewire\Chat;

use App\Models\Chat\Message;
use App\Models\User;
use Livewire\Component;

class ChatList extends Component
{
    public $users;
    public $messages;

    public function checkconversation($receiverId)
    {
        // dd($receiverId);

        $this->emit('getReceiverId', $receiverId);
        $this->emitTo('chat.chatbox', 'getBottom');

    }

    public function render()
    {
        $this->users = User::where('id', '!=', auth()->user()->id)->get();
        $this->messages = Message::all();
        return view('livewire.chat.chat-list');
    }
}

