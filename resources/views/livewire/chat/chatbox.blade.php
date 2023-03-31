<div>
    {{-- prawa strona kolumny  strony chat --}}
    {{--zmioenna prtzeslana za pomoca   $this->emitTo('chat.chatbox', 'loadConversation', $this->selectedConversation, $receiverInstance);--}}
    @if ($selectedConversation)
        <div class="chatbox_header">

            <div class="return">
                <i class="bi bi-arrow-left"></i>
            </div>

            <div class="img_container">
                {{--zmioenna prtzeslana za pomoca   $this->emitTo('chat.chatbox', 'loadConversation', $this->selectedConversation, $receiverInstance);--}}
                <img src="https://ui-avatars.com/api/?name={{ $receiverInstance->name }}" alt="">

            </div>

            <div class="name">
                {{ $receiverInstance->name }}
            </div>

            <div class="info">

                <div class="info_item">
                    <i class="bi bi-telephone-fill"></i>
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
                {{--rozroznia usera aktualnie zaloghowanegood niezalogowanego i generowanie nazw klas--}}
                <div class="msg_body  {{ auth()->id() == $message->sender_id ? 'msg_body_me' : 'msg_body_receiver' }}"
                     style="width:80%;max-width:80%;max-width:max-content">

                    {{ $message->body }}
                    <div class="msg_body_footer">
                        <div class="date">
                            {{ $message->created_at->format('m: i a') }}
                        </div>

                        <div class="read">
                            {{-- sprawdzenie czy dana wiadmosc byla przeczytana i nadanie przeczytanymwiadomoscia "ptaszka" z apomca klas css--}}
                            @php
                                if($message->user->id === auth()->id()){

                                    if($message->read == 0){
                                        echo'<i class="bi bi-check2 status_tick "></i> ';
                                          }
                                          else {
                                              echo'<i class="bi bi-check2-all text-primary  "></i> ';
                                          }

                                }


                            @endphp


                        </div>
                    </div>
                </div>
            @endforeach

        </div>


        <script>
            $(".chatbox_body").on('scroll', function () {
                // alert('aahsd');
                var top = $('.chatbox_body').scrollTop();
                //   alert('aasd');
                if (top == 0) {
//wywolanie metody load more z chatbox class - njprwd ladowanie wikeszej ilosci konwersacji przy skrolowaniu
                    window.livewire.emit('loadmore');
                }

            });
        </script>


        <script>
            /**
             * njpwrd jest to obslig scrolingu w gore
             */
            //updatedHeight - nazwa cutomowego zdanierza zdef w chatbox load more (dispacth to browser)
            //zdarzenie to przechowuje zmienna height - i ja zwraca
            //przypisanie zdarzenia do obiekrtu okna przegldarki a nastepnie przypisania mu okreslonego zadania
            window.addEventListener('updatedHeight', event => {

                let old = event.detail.height;
                let newHeight = $('.chatbox_body')[0].scrollHeight;
//wylicznaie wyskosci
                let height = $('.chatbox_body').scrollTop(newHeight - old);

//emisja wyliczonej wyskosci do przegladrki z apomoca  mechanizm livewire
                window.livewire.emit('updateHeight', {
                    height: height,
                });


            });
        </script>
    @else
        <div class="fs-4 text-center text-primary mt-5">
            no conversasion selected
        </div>

    @endif


    <script>
        /**
         * njpwrd jest to obslig scrolingu w dol - gdy przeslana wiadmosc rob miesjce na dole
         */
        //rowChatToBottom - zdarzenie z gloszone i przelsane w push message w chatbox klasie
        window.addEventListener('rowChatToBottom', event => {

            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);

        });
    </script>


    <script>

        /**
         * jest to obsluga klikniecia strzalki u gory w chat page  przy praweej koliumnie
         *
         * resetowanie clwego okinka powoduje czyszczenie okinka z w wiadmosci!!!
         *
         */
        //return nazwa klasy css- "klikajac w elemtu  ktre maja ta klase wyzwol metode callback"
        $(document).on('click', '.return', function () {

//resetComponent - jakonlistener okreslony w chatbox i send message class jako metoda ktore restuje -   $this->selectedConversation= null;
            //   $this->receiverInstance= null;
            //resetowanie komponentu po wyjsciu z czatu
            window.livewire.emit('resetComponent');

        });
    </script>


    <script>
        /**
         * obsluga oznaczania wiadomosci jako przewczytane
         * wszytsko analogocznie ja powyzej
         *
         */
        window.addEventListener('markMessageAsRead', event => {
            var value = document.querySelectorAll('.status_tick');

            value.array.forEach(element, index => {


                element.classList.remove('bi bi-check2');
                element.classList.add('bi bi-check2-all', 'text-primary');
            });

        });

    </script>
</div>
