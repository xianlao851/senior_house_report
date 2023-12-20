<?php

namespace App\Http\Livewire\AddPatient;

use App\Models\Patient;
use Livewire\Component;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\Operation;
use App\Models\ShoDetail;
use App\Models\Nationality;
use App\Models\Municipality;
use App\Models\PatientAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddPatientTable extends Component
{
    use LivewireAlert;
    /*-- models for address--*/
    public $province_id;
    public $municipality_id;
    public $barangay_id;
    public $municipalities;
    public $barangays;
    /*-- models for address--*/

    /*-- model for patient info--*/
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix;
    public $preffix;
    public $alias;
    public $birth_date;
    public $patient_address_id ;
    public $contact_no ;
    public $birth_place ;
    public $gender;
    public $civil_stat ;
    public $emp_stat ;
    public $ethnicity;
    public $nationality_id;
    public $religion ;
    public $blood_type;
    public $entry_by;
    public $record_date;
    public $email;
    public $age;
    /*-- model for patient info--*/
    public $address;
    public $get_date;
    public $get_patients;
    public $nationalities;
    public $get_sho_detail;
    public $patients;
    public $get_patient_id;

    public $getid;
    public $operation_done;

    public function mount()
    {
        $date = date('Y-m-d');
        $this->get_date= $date;
        $this->nationality_id =608;
        $this->nationalities=Nationality::all();
        $this->get_sho_detail= ShoDetail::all()->last();

    }

    public function updatedBirthDate()
    {
        //$this->age = Carbon::parse($this->birth_date)->age;
        //$this->age = Carbon::parse($this->birth_date)->diff(Carbon::now())->format('%y years, %m months and %d days');
        $this->age = Carbon::parse($this->birth_date)->diff(Carbon::now())->format('%y years, %m months');
    }
    public function render()
    {

        $provinces=Province::all();
        return view('livewire.add-patient.add-patient-table',[
            'provinces'=>$provinces,
        ]);
    }

    public function updatedProvinceId()
    {
           $this->municipalities = Municipality::where('province_id',$this->province_id)->get();
     }

     public function updatedMunicipalityId()
     {
        $this->barangays = Barangay::where('municipality_id',$this->municipality_id)->get();
     }

    //  public function updatedNationalityId()
    //  {
    //     $this->nationalities = Nationality::where('nationality_id', $this->nationality_id)->get();
    //  }
     public function save()
     {

        $this->validate([
            'province_id'=> ['required'],
            'municipality_id' => ['required'],
            'barangay_id' => ['required'],
        ]);

        PatientAddress::create([
        'province_id' => $this->province_id,
        'municipality_id' => $this->municipality_id,
        'barangay_id' =>$this->barangay_id,
        ]

        );

        $this->address = PatientAddress::all();
        $getpatientaddresss= $this->address->last();

        $this->validate([
            'first_name' => ['required'],
            'last_name'=> ['required'],
            'age'=> ['required'],
            'birth_date'=> ['required'],
            'contact_no'=> ['required'],
            'birth_place'=> ['required'],
            'civil_stat'=> ['required'],
            'emp_stat'=> ['required'],
            'nationality_id'=> ['required'],
            'blood_type'=> ['required'],
        ]);

        Patient::create([
            'first_name' =>$this->first_name,
            'middle_name' =>$this->middle_name,
            'last_name' =>$this->last_name,
            'suffix' =>$this->suffix,
            'preffix' =>$this->preffix,
            'alias' =>$this->alias,
            'gender' =>$this->gender,
            'birth_date' =>$this->birth_date,
            'patient_address_id' =>$getpatientaddresss->id,
            'contact_no' =>$this->contact_no,
            'birth_place' =>$this->birth_place,
            'civil_stat' =>$this->civil_stat,
            'emp_stat' =>$this->emp_stat,
            'ethnicity' =>$this->ethnicity,
            'nationality' =>$this->nationality_id,
            'religion' =>$this->religion,
            'blood_type' =>$this->blood_type,
            'entry_by' =>$this->get_sho_detail->id,
            'record_date' =>$this->get_date,
            'age'=>$this->age,
        ]);
        return redirect()->route('patientlist');
        // $this->patients=Patient::all();
        // $this->get_patient_id=$this->patients->last();

        // $this->get_patients=Patient::all();
        // $get_patient_id=$this->get_patients->last();
        // //dd($get_patient_id->id);
        // return redirect()->route('addOperationDone', ['id' => $get_patient_id->id]);
     }

    //  public function save_operation()
    //  {
    //     Operation::create([
    //      'patient_id' =>$this->get_patient_id->id,
    //      'operation_done' =>$this->operation_done,
    //     'record_date'=>$this->get_date,
    //     ]);
    //     return redirect()->route('reports');
    //  }
    //  public function cancel()
    //  {
    //     return redirect()->route('reports');
    //  }

}
