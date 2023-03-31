<?php

namespace App\Http\Livewire\Chat;

use App\Models\Team;

use Illuminate\Http\Request;
use Livewire\Component;

class Main extends Component
{
    public function render(Request $request)
    {
        return view('livewire.chat.main');
    }
}
