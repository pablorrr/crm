<div>
    {{--lewa kolumna stront chat --}}

    <div class="chatlist_header">

        <div class="title">
            Chat
        </div>

        <div class="img_container">
            <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{auth()->user()->name}}" alt="">
        </div>
    </div>

    <div class="chatlist_body">
        {{-- drukowanie konwersacji - nazwy oosob do rosmzowy--}}
        @if (count($conversations) > 0)
            {{--pochodzenie-   $this->conversations = Conversation::where('sender_id', $this->auth_id)--}}
            @foreach ($conversations as $conversation)
                {{--chatUserSelected - urychomienei metody  zprzeslanymi parmaetrami -def w chat list , po kliknieciu w dana ososbe wyswietl  cala konwersacje --}}
                <div class="chatlist_item" wire:key='{{$conversation->id}}'
                     wire:click="$emit('chatUserSelected', {{$conversation}},{{$this->getChatUserInstance($conversation, $name = 'id') }})">
                    <div class="chatlist_img_container">
                        {{--getChatUserInstance -pobranie nazwy uswra i  drukowanie przy liscie userow do konwersacji--}}
                        <img
                            src="https://ui-avatars.com/api/?name={{$this->getChatUserInstance($conversation, $name = 'name')}}"
                            alt="">
                    </div>

                    <div class="chatlist_info">
                        <div class="top_row">
                            {{--drukowanie samej nazy uzytkownika--}}
                            <div class="list_username">{{ $this->getChatUserInstance($conversation, $name = 'name') }}
                            </div>
                            <span class="date">
                                {{-- system powiazan miejdzy tabelamio  conversations a messeges dzikei laarvel relationship--}}
                                {{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans() }}</span>
                        </div>

                        <div class="bottom_row">

                            <div class="message_body text-truncate">
                                {{--drukowanie tresci ostatnej wiadmosci w lewej koluknie przy nazwisku wioadomosci--}}
                                {{ $conversation->messages->last()->body }}
                            </div>
                            {{--wyswietl liczbe nieprzeczytannych woadmosci--}}
                            @php
                                if(count($conversation->messages->where('read',0)->where('receiver_id',Auth()->user()->id))){

                             echo ' <div class="unread_count badge rounded-pill text-light bg-danger">  '
                                 . count($conversation->messages->where('read',0)->where('receiver_id',Auth()->user()->id)) .'</div> ';

                                }

                            @endphp

                        </div>
                    </div>
                </div>

            @endforeach

        @else
            you have no conversations
        @endif


        @if(is_object($noConversationsUsers) && count($noConversationsUsers) > 0)

            @foreach ($noConversationsUsers as $item)

                @php
                    if($item->id == auth()->user()->id) {continue;}
                @endphp

                <div class="chatlist_item">

                    <div class="chatlist_img_container">

                        <img src="https://ui-avatars.com/api/?name= {{ $item->name }}" alt="">
                    </div>
                    <div class="chatlist_info">
                        <div class="top_row">

                            <div wire:click='checkconversation({{$item->id}})' class="list_username">{{ $item->name }}
                            </div>

                        </div>
                    </div>


                </div>

            @endforeach
        @endif


    </div>
</div>
