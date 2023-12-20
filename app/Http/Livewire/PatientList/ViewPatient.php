<?php

namespace App\Http\Livewire\PatientList;

use Livewire\Component;

class ViewPatient extends Component
{
    public $getId;
    public function render()
    {
        return view('livewire.patient-list.view-patient');
    }
}
