<?php

namespace App\Http\Livewire\Chat;


use App\Models\Chat\Conversation;
use App\Models\Chat\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChatList extends Component
{


    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedConversation;
    public $users;

    public $noConversationsUsers;
    public $message = 'hello how are you ';

////odbiorcy jako metody tej klasy, moga vbyc uzyte przy kluczu wire i dpalane jako zdarzenie w js
    protected $listeners = [
        'chatUserSelected', 'refresh' => '$refresh', 'resetComponent'
    ];//odbiorcy jako metody tej klasy,


    public function resetComponent()
    {

        $this->selectedConversation = null;
        $this->receiverInstance = null;

        # code...
    }

//uzycie w chat list blade - jest to listener   po kliknieciu w dana ososbe wyswietl  cala konwersacje , korespomduje z JS wire: (blade)
    public function chatUserSelected(Conversation $conversation, $receiverId)
    {
        //  dd($conversation,$receiverId);
        $this->selectedConversation = $conversation;
        $receiverInstance = User::find($receiverId);
        //njpwrd emit to to inczej emitouj do zdrzeni czyv tez przypisz doz darzenia
        //wyemituj do chat.chatbox zdareznie ze zdarzeniami
        $this->emitTo('chat.chatbox', 'loadConversation', $this->selectedConversation, $receiverInstance);
        $this->emitTo('chat.send-message', 'updateSendMessage', $this->selectedConversation, $receiverInstance);

        # code...
    }

//wyciaganie nazwy usytkownikka z bazdy danych - uzycie przy lewej kolumnie na stronie chat

    public function getChatUserInstance(Conversation $conversation, $request)//odniesienie do chat list balde
    {
        # code...
        $this->auth_id = auth()->id();
        //get selected conversation
        //gdy wysylajacy jest aktualnie zalogowany
        if ($conversation->sender_id == $this->auth_id) {
            //to jest zaawszer tym co otrzymuje wiadomosc(sam do siebie nie moze wyslaac wiadmosci)  a zatem...
            $this->receiverInstance = User::firstWhere('id', $conversation->receiver_id);
            # code...
        } else {
            //gdy niezalogowany wyswietl nazwy uztyjiwbika jako wysylajacegho
            $this->receiverInstance = User::firstWhere('id', $conversation->sender_id);
        }

        if (isset($request)) {
//reqeust jako parametr name - zwrovcenie nazwy usera
            return $this->receiverInstance->$request;
            # code...
        }
    }

//metoda zaszyta w mechanizmach livewire
    public function mount()//zmontuj???
    {

        $this->auth_id = auth()->id();
        $this->conversations = Conversation::where('sender_id', $this->auth_id)
            ->orWhere('receiver_id', $this->auth_id)->orderBy('last_time_message', 'DESC')->get();

        # code...
    }


//fumkcja  ma zastsowanie w  create chat blade!!!
//stworz konwersacje jeli nie ma zadnych
//po klikniecie w usera stworzy sie z automatu wiadomosc hell how are you - do modyfikacj

    public function checkconversation($receiverId)
    {

        // dd($receiverId);
        $checkedConversation = Conversation::where('receiver_id', auth()->user()->id)->where('sender_id',
            $receiverId)->orWhere('receiver_id', $receiverId)->where('sender_id', auth()->user()->id)->get();

        if (count($checkedConversation) == 0) {

            // dd(no conversation);
            //dodoaj rekord w tabeli conversation
            $last_time_message = date('Y-m-d H:i:s', mt_rand(1, time()));

            $createdConversation = Conversation::create([
                'receiver_id' => $receiverId,
                'sender_id' => auth()->user()->id,
                'last_time_message' => $last_time_message
            ]);
            /// conversation created
            //dodaj nowy rekord w tabeli message
            $createdMessage = Message::create([
                'conversation_id' => $createdConversation->id,
                'sender_id' => auth()->user()->id,
                'receiver_id' => $receiverId,
                'body' => $this->message
            ]);


            $createdConversation->last_time_message = $createdMessage->created_at;
            $createdConversation->save();

            // dd($createdMessage);
            //   dd('saved');


        } else {
            if (count($checkedConversation) >= 1) {

                dd(
                    'conversation exists'
                );
            }
        }
        # code...
    }


    public function usersWithoutConversation()
    {
        //get users id with conversations
        $convers_users = DB::table('conversations')->select('receiver_id')->get()->toArray();//konwersja do tablicy obiektow

        if (is_array($convers_users) && !empty($convers_users)) {

            $id_arr = [];
            foreach ($convers_users as $obj_item) {
                array_push($id_arr, $obj_item->receiver_id);
            }

            //pobierz tych userow ktorzy nie odbyli konwersacji
            return \App\Models\User::select('name', 'id')->whereNotIn('id', $id_arr)->get();


        } else {
            return \App\Models\User::select('name', 'id')->get();
        }

    }

    public function render()
    {
        $this->noConversationsUsers = $this->usersWithoutConversation();
        $this->users = User::where('id', '!=', auth()->user()->id)->get();

        return view('livewire.chat.chat-list');
    }
}
