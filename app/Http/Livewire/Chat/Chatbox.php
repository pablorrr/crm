<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use App\Events\MessageRead;
use App\Models\Chat\Conversation;
use App\Models\Chat\Message;
use App\Models\User;
use Livewire\Component;

/**
 * jedna z klas bedaca komponenetmi livewire (substytut kontrolerow)
 * kazda z tych klas oblsuguje dany szbalon blade - na koniec klasy metoda render

 **/
class Chatbox extends Component
{

    public $selectedConversation;
    public $receiver;
    public $messages;
    public $paginateVar = 10;
    public $height;

    // protected $listeners = [ 'loadConversation', 'pushMessage', 'loadmore', 'updateHeight', "echo-private:chat. {$auth_id},MessageSent"=>'broadcastedMessageReceived',];

//overwrite getListeners w ReceiveEvents.php powioazania z events
//pobierz nasluchwiaczy - jest to nawiwzane do wzorrca Obserwator : nasluch, nadajacy sygnal .odbiorcy
//utworz odbiorcow - przypisz im okreslone zdarzenia i do zdarzen przypisz okreslone meody - pbsluge zdarzen

    public function getListeners()
    {
        //MessageSent - nazwy klas w Events (klasy obslugiujace wydarzenia )

        $auth_id = auth()->user()->id;
        return [
            //echo-private:chat.{$auth_id} - obiorca
            //zdarzenie MessageSent
            //broadcastedMessageReceived - przypsana metoda do zdarzen

            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',//nazwa metody patrz linia 66
            "echo-private:chat.{$auth_id},MessageRead" => 'broadcastedMessageRead',//linia 46
            'loadConversation', 'pushMessage', 'loadmore', 'updateHeight', 'broadcastMessageRead', 'resetComponent'
            //patrz linia 37
        ];
    }

//meoda zgloszona jako  listener - odbiorca w klasie chat list
//odwolane  w chatbox blade
//resetrowanie komponentu po wyjsciu z chatu
    public function resetComponent()
    {

        $this->selectedConversation = null;
        $this->receiverInstance = null;

        # code...
    }

//powiazanie ze zdrzeniem meeasage read
//njpwrd nadaj wiadomosc

    public function broadcastedMessageRead($event)
    {
        //dd($event);

        if ($this->selectedConversation) {
//conversation_id - powiazanie z tabela meesege - jest naqzwa klucza obcego, uzycie w meesege read
            //

            if ((int) $this->selectedConversation->id === (int) $event['conversation_id']) {

                $this->dispatchBrowserEvent('markMessageAsRead');//njprwd przeslij zdrzenie do przegldarki
            }

        }

        # code...
    }
    /*---------------------------------------------------------------------------------------*/
    /*-----------------------------Broadcasted Event function-------------------------------------------*/
    /*----------------------------------------------------------------------------*/
//njprwd nadaj wiadomosc otrzymana
    function broadcastedMessageReceived($event)
    {
        ///here
        $this->emitTo('chat.chat-list', 'refresh');//wyemituj zdarzenie do odbiorcy
        # code...

        $broadcastedMessage = Message::find($event['message']);//stworzenie wiadomosci do nadania


        #check if any selected conversation is set
        if ($this->selectedConversation) {
            #check if Auth/current selected conversation is same as broadcasted selecetedConversation
            if ((int) $this->selectedConversation->id === (int) $event['conversation_id']) {
                # if true  mark message as read
                $broadcastedMessage->read = 1;//jesli wiadomosc zostala oznaczon ajko przeczytana oznacz w polu kolumny read jako przeczytana
                $broadcastedMessage->save();//zachowaj zmiany
                //push message to chat seelianie 117
                $this->pushMessage($broadcastedMessage->id);//njprwd przeslanie inforacji ze wiadomosc przeczytana
                // dd($event);
//wyemituj zdarzenie
                $this->emitSelf('broadcastMessageRead');//nazwa metody powiazanej ze zdarzeniem
            }
        }
    }


    public function broadcastMessageRead()
    {//rozpocznij nadawanie zdarznia
        broadcast(new MessageRead($this->selectedConversation->id, $this->receiverInstance->id));
        # code...
    }

    /*--------------------------------------------------*/
    /*------------------push message to chat--------------*/
    /*------------------------------------------------ */
    //uwaga czesc metod wspolgra ze javascript!!!!
    public function pushMessage($messageId)
    {
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatchBrowserEvent('rowChatToBottom');//rowChatToBottom - odwolanie sie do chatboxblade
        # code...
    }



    /*--------------------------------------------------*/
    /*------------------load More --------------------*/
    /*------------------------------------------------ */

    //load more odwolanie w chat box blade oraz main blade

    function loadmore()
    {
        //njpwrd  wspoltworzenie mechganizmu load more messeges
        // dd('top reached ');
        $this->paginateVar = $this->paginateVar + 10;
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();
        //pojnizej opgraniczenbuie wynikow wyszukiwan

        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)
            ->take($this->paginateVar)->get();

        $height = $this->height;
        //njpwrd przeslinj zdarzenie do przegldarfki
        $this->dispatchBrowserEvent('updatedHeight', ($height));
        # code...
    }


    /*---------------------------------------------------------------------*/
    /*------------------Update height of messageBody-----------------------*/
    /*---------------------------------------------------------------------*/

    //$this->dispatchBrowserEvent('updatedHeight', ($height)); - wykorzytsanie przy
    function updateHeight($height)
    {

        // dd($height);
        $this->height = $height;

        # code...
    }



    /*---------------------------------------------------------------------*/
    /*------------------load conversation----------------------------------*/
    /*---------------------------------------------------------------------*/
    //load conversation powiazanie ze zdarzeniem message read
    //njpwrd ladowanie wiadomosci do okienka

    public function loadConversation(Conversation $conversation, User $receiver)
    {


        //  dd($conversation,$receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;

//zlicz ilosc wiadomosci
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)//opusc te wiadomosci
            ->take($this->paginateVar)->get();//pobierz te wiadomosci
        //uzycie events payrzr doc laravel
        //uzycie  desgin pattern observer patrz  gurtu porjexct
        //piwazanie z main blade njpwd dzikie temu jest mozliwe wywolanie w javascript windows. etc.etc. w blade
        //njpwrd jest to powiazane z wire:: (sprawdzic too!!!)

        $this->dispatchBrowserEvent('chatSelected');//piwazanie z main blade njpwd dzikie temu jest mozliwe wywolanie w javascript windows. etc.etc. w blade

        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id', auth()->user()->id)->update(['read' => 1]);

        $this->emitSelf('broadcastMessageRead');//zdef na  samej gorze
        # code...
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
