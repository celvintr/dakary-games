<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class SelectDealer extends Component
{

    public $module, $listener;

    public function mount($module, $listener)
    {
        $this->module   = $module;
        $this->listener = $listener;
    }

    public function render()
    {
        return view('livewire.components.select-dealer');
    }
}
