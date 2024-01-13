<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="chatlist_header">
        <div class="title">
            {{-- 'Chat'--}}
        </div>

        <div class="">
            <h2> Me logged :{{auth()->user()->name}} </h2>
        </div>
    </div>

    <div class="chatlist_body">

        @foreach ($users as $user)
            <div class="chatlist_item" wire:click='checkconversation({{$user->id}})'>
                <div class="chatlist_img_container">

                    <img src="https://ui-avatars.com/api/?name={{  $user->name }}"
                         alt="">
                </div>

                <div class="chatlist_info">
                    <div class="top_row">
                        <div class="list_username">{{   $user->name }}</div>
                        <div class="list_username">{{   $user->email }}</div>
                        <span class="date"></span>
                    </div>

                    <div class="bottom_row">
                        <div class="message_body text-truncate"></div>
                        @php  echo ' <div class="unread_count badge rounded-pill text-light bg-danger"> '.
                            count($messages->where('receiver_id',$user->id)) .'</div> ';@endphp
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
