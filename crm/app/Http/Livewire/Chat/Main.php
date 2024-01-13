<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;

class Main extends Component
{
    //uwaga!!! wystepujaca metoda push w oryginalnym przykladzie jestmetoda  kolekcji modelu laravel
    public function render()
    {
        return view('livewire.chat.main');
    }
}
