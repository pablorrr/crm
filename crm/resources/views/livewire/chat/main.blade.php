<div>
    <div class="chat_container">

        <!--kontener z lista userow nbioracych udzila w czacie-->
        <div class="chat_list_container">

            @livewire('chat.chat-list')

        </div>

        <div class="chat_box_container">
            <!--kontener z tescia  wiadmosci-->
            @livewire('chat.chatbox')

            @livewire('chat.send-message')
        </div>
    </div>
   <!-- <script>
        // $(document).on('click', '#btn', function () {
        // alert('jquery test');
        //  window.livewire.emit('loadmore');

        //console.log(window.livewire);
     //   })
       // ;
    </script>-->
</div>
