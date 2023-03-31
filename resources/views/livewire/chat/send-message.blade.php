<div>
    {{-- The whole world belongs to you. --}}

    @if ($selectedConversation)
        {{--obsluga wysylania wiadmosci na dole chatbox korzystania z metody send message w klasie sendmessgge--}}
        <form wire:submit.prevent='sendMessage' action="">
            <div class="chatbox_footer">
            <div class="custom_form_group">
{{-- <input wire:model='body' - njpwrd powiazznie wysylnej tresi z modelem messeges i jego kulumna body--}}
                <input wire:model='body' type="text" id="sendMessage" class="control" placeholder="Write message">
            <button type="submit" class="submit">Send</button>
            </div>

            </div>
        </form>

    @endif

</div>
