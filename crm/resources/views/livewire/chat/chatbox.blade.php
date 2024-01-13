<div>
    <div>
        {{-- <button id="btn" type="button" class="btn btn-primary">loadmore</button> --}}
        <div class="chatbox_header">
            <div class="info">
                {{-- todo: pozbyc sie foreeach zastosowac jedna z metad konwersji danyhc tyou to jason--}}
                @foreach ($receiverInstance as $reSingleIns)
                    <div class="info">
                        <p class="info_item">{{'Im writing to'}}</p>
                        <i class="bi bi-arrow-right"></i>
                        <p class="info_item">{{$reSingleIns->name}}</p>
                    </div>

                @endforeach

            </div>

            <div class="info_item">
                <i class="bi bi-image"></i>
            </div>

            <div class="info_item">
                <i class="bi bi-info-circle-fill"></i>
            </div>
        </div>
    </div>


    <div class="chatbox_body">

        @foreach ($messages as $message)

            <div class="msg_body  {{ auth()->id() == $message->sender_id ? 'msg_body_receiver':'msg_body_me'   }}"
                 style="width:80%;max-width:80%;max-width:max-content">
                <p>{{ $message->body }}</p>
                @php
                    if($message->read !== 0 && auth()->id() == $message->sender_id){echo'<i class="bi bi-check2-all text-primary"></i> ';}
                          else {echo'<i class="bi bi-check2 status_tick "></i> ';}
                @endphp

            </div>

        @endforeach

    </div>
    {{--<div>
         <button wire:click="$refresh">Reload Component</button>
     </div>--}}

</div>

<script>

    window.addEventListener('rowChatToBottom', event => {
        // alert('rowChatToBottom - OK');
        $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);

    });
</script>
