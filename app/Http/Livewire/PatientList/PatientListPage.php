<?php

namespace App\Http\Livewire\PatientList;

use App\Models\Patient;
use Livewire\Component;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\Operation;
use App\Models\Nationality;
use App\Models\Municipality;
use App\Models\ShoTransferTo;
use App\Models\PatientAddress;
use App\Models\ShoTransferFrom;
use PHPUnit\Framework\Constraint\Operator;
use Carbon\Carbon;
use Livewire\WithPagination;
class PatientListPage extends Component
{
    use WithPagination;

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
    public $nationality;
    public $religion ;
    public $blood_type;
    public $age;
    public $entry_by;
    public $record_date;
    /*--------- */

    public $getFirstname;
    public $province_id;
    public $municipality_id;
    public $barangay_id;
    public $municipalities;
    public $barangays;
    public $nationalities;
    public $getPatientId;

    public $getaddress;
    public $editPatient;
    public $getprovince;
    public $getmunicipality;
    public $getbarangay;

    public $getPatientInfo;
    public $getPatientOperations;
    public $getTransferFrom;
    public $getTransferTo;
    public $count=1;

    public $search_patient;
    public $get_option;

    public $getId;
    public $patientlist;
    public function mount()
    {
        $this->nationalities=Nationality::all();
    }
    public function updatedBirthDate()
    {
        $this->age = Carbon::parse($this->birth_date)->diff(Carbon::now())->format('%y years, %m months');
    }
    public function render()
    {
        $provinces=Province::all();

        if(strlen($this->get_option)>=1 && strlen($this->search_patient)>=1 )
        {
            $patients = Patient::where($this->get_option, 'like', '%'.$this->search_patient.'%')->paginate(10,['*'], 'patientlist');

        }
        else
        {
            $patients=Patient::orderBy('last_name','asc')->paginate(10,['*'],'patientlist');
        }
        return view('livewire.patient-list.patient-list-page',[
            'patients'=>$patients ?? null,
            'provinces'=>$provinces ?? null,
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

     public function get_patient($id)
     {
        $this->editPatient = Patient::find($id);
        $this->getPatientId = $this->editPatient->id;
        $this->first_name =$this->editPatient->first_name;
        $this->middle_name =$this->editPatient->middle_name;
        $this->last_name =$this->editPatient->last_name;
        $this->suffix =$this->editPatient->suffix;
        $this->preffix =$this->editPatient->preffix;
        $this->alias =$this->editPatient->alias;
        $this->birth_date =$this->editPatient->birth_date;
        $this->patient_address_id  =$this->editPatient->patient_address_id;
        $this->contact_no  =$this->editPatient->contact_no;
        $this->birth_place  =$this->editPatient->birth_place;
        $this->gender =$this->editPatient->gender;
        $this->civil_stat  =$this->editPatient->civil_stat;
        $this->emp_stat  =$this->editPatient->emp_stat;
        $this->ethnicity =$this->editPatient->ethnicity;
        $this->nationality =$this->editPatient->nationality;
        $this->religion  =$this->editPatient->religion;
        $this->blood_type =$this->editPatient->blood_type;
        $this->age= $this->editPatient->age;

        $this->getaddress = PatientAddress::find($this->editPatient->patient_address_id);
        $this->province_id = $this->getaddress->province_id;
        $this->municipality_id = $this->getaddress->municipality_id;
        $this->barangay_id = $this->getaddress->barangay_id;

        $province = Province::find($this->province_id);
        $this->getprovince = $province->province_name;

        $this->municipalities = Municipality::where('province_id',$this->province_id)->get();

        $this->barangays = Barangay::where('municipality_id',$this->municipality_id)->get();


     }

     public function update()
    {

        $editPatient= Patient::find($this->getPatientId);

       $editPatient->first_name= $this->first_name;
       $editPatient->middle_name = $this->middle_name;
       $editPatient->last_name = $this->last_name;
       $editPatient->suffix = $this->suffix;
       $editPatient->preffix = $this->preffix;
       $editPatient->alias = $this->alias;
       $editPatient->birth_date = $this->birth_date;
       $editPatient->contact_no =$this->contact_no;
       $editPatient->birth_place = $this->birth_place;
       $editPatient->gender = $this->gender;
       $editPatient->civil_stat = $this-> civil_stat;
       $editPatient->emp_stat = $this->emp_stat;
       $editPatient->ethnicity = $this->ethnicity;
       $editPatient->nationality = $this->nationality;
       $editPatient->religion = $this->religion;
       $editPatient->blood_type =$this->blood_type;
       $editPatient->save();

       $editPatientAddress = PatientAddress::find($editPatient->patient_address_id);
       $editPatientAddress->province_id = $this->province_id;
       $editPatientAddress->municipality_id = $this->municipality_id;
       $editPatientAddress->barangay_id = $this->barangay_id;
       $editPatientAddress->save();

       return redirect()->route('patientlist');

    }

    public function view_patient($id)
    {
        $this->getId=$id;

        $patient=Patient::where('id', $this->getId)->first();
        $this->getPatientInfo=$patient;

        $operation=Operation::where('patient_id', $this->getId)->get();
        $this->getPatientOperations = $operation;
       // dd($this->getPatientOperations);
        $transferFrom=ShoTransferFrom::where('patient_id', $this->getId)->first();
        $this->getTransferFrom=$transferFrom;

        $transferTo=ShoTransferTo::where('patient_id', $this->getId)->first();
        $this->getTransferTo=$transferTo;



    }

    public function close()
    {
        //$this->getPatientInfo=null;
        return redirect()->route('patientlist');
    }
    public function clear()
    {
        return redirect()->route('patientlist');
    }
}
