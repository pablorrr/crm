<div class="chat_container">


    <!--kontener z lista userow bioracych udzila w czacie-->
    <div class="chat_list_container ">
        <button onClick="window.location.reload();">Refresh Page if you cant see changes</button>

        @livewire('chat.chat-list')

    </div>


    <div class="chat_box_container">
        <!--kontener z tescia  wiadmosci-->

        @livewire('chat.chatbox')

        @livewire('chat.send-message')


    </div>


    <script>
        //chatselected dzialdzkei disptach browser (ctrl+shift+f)
        window.addEventListener('chatSelected', event => {
            //responsive handle
        /**    if (window.innerWidth < 168) {

                $('.chat_list_container').hide();
                $('.chat_box_container').show();

            }**/

            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
            let height = $('.chatbox_body')[0].scrollHeight;
            //alert(height);
            window.livewire.emit('updateHeight', {

                height: height,


            });
        });

        //responsive handle
       /** $(window).resize(function () {

            if (window.innerWidth > 168) {
                $('.chat_list_container').show();
                $('.chat_box_container').show();

            }

        });**/

        //pokaz ukryj wiadomosci po kliknieciu w danego usera w zakaldce chat
        $(document).on('click', '.return', function () {

            $('.chat_list_container').show();
            $('.chat_box_container').hide();


        });
    </script>

    <script>
        // //let el= $('#chatBody');
        // let el = document.querySelector('#chatBody');
        // window.addEventListener('scroll', (event) => {
        //     // handle the scroll event
        //     alert('aasd');

        // });
        $(document).on('scroll', '#chatBody', function () {
            alert('aasd');

            var top = $('.chatbox_body').scrollTop();
            if (top == 0) {

                window.livewire.emit('loadmore');//njpwrd oblsuga paginacji  lub ladowania nowych konwersacji
            }


        });

    </script>
</div>
