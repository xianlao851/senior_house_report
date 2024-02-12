<?php

namespace App\Http\Livewire\ViewPatient;

use App\Models\Patient;
use Livewire\Component;
use App\Models\Operation;
use App\Models\ShoDetail;
use App\Models\Department;
use App\Models\ShoIncident;
use App\Models\ShoSignificantEvent;

class ViewPatientPage extends Component
{
    public $get_id;
    public $getdivision = 8;
    public $get_sho_detail;
    public $get_date;
    public $getCount;
    public $i = 1;
    //public $patients;
    public function mount($id)
    {
        $this->get_id = $id;
        $date = date('Y-m-d');
        $this->get_sho_detail = ShoDetail::all()->last();
    }
    public function render()
    {
        //dd($this->get_id);
        $detail = ShoDetail::where('id', $this->get_id)->first();
        $this->get_date = $detail->report_date;
        $this->getCount = Operation::where('record_date', $this->get_date)->count();
        $operations = Operation::where('record_date', $this->get_date)->get();
        $departments = Department::where('division_id', $this->getdivision)->get();
        $incidents = ShoIncident::where('sho_id', $detail->emp_id)->get();
        $significanIncidents = ShoSignificantEvent::where('date_created', $this->get_date)->get();
        return view('livewire.view-patient.view-patient-page', [
            'operations' => $operations ?? null,
            'detail' => $detail ?? null,
            'incidents' => $incidents ?? null,
            'departments' => $departments ?? null,
            'significanIncidents' => $significanIncidents ?? null,

        ]);
    }
}
