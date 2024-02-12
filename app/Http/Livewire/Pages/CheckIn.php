<?php

namespace App\Http\Livewire\Pages;

use App\Models\Patient;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Hospital;
use App\Models\ShoDetail;
use App\Models\ShoMoDuty;
use App\Models\ShoMsDuty;
use App\Models\Department;
use App\Models\HrisEmployee;
use Livewire\WithPagination;
use App\Models\ShoTransferTo;
use App\Models\HospitalHerlog;
use App\Models\HrisDepartment;
use App\Models\HospitalPatient;
use App\Models\ShoTransferFrom;
use App\Models\HospitalHencdiag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Carbon\Carbon;
use DateTime;

class CheckIn extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $listeners = ['try', 'deleteComfirmedMo', 'deleteComfirmedMs', 'deleteComfirmedTransferFrom', 'deleteComfirmedTransferTo'];

    public $current_detail = null, $patient_id;
    public $selected_patient;

    public $senior_house_officer, $report_date;
    public $doctor_id;
    public $diagnosis, $reason;
    public $facility;
    public $getShoDetail;
    public $getTrasnsferFrom;
    public $getTrasnsferTo;
    public $getHospitalIds;
    public $getdetail;

    public $patientFromId;
    public $patienToId;

    public $triggerButton;
    public $hidebtn;
    public $valpatient;

    public $get_option;
    public $search_patient;
    public $get_patient;
    public $catchId;

    public $trasnferfrom;
    public $trasnsferTo;
    public $patient;
    public $getDiag;
    public $getCurrentDateTime;
    public $btn;
    public $getReportDate;
    public $getDiffHours;
    public $inc_depts = [13, 15, 12, 8, 14, 87, 9, 7, 65];
    public $position = [19, 18, 57, 58, 59, 22];
    public $search_doctor;
    public $get_doctor;
    public $selected_doctor;
    //public $doctors;
    protected $get_doctors;
    //public $get_patients;
    protected $get_patients;
    public $get_logs;
    public $recordDate;
    public $currentDate;
    public $getTime;
    public $getId;

    public $patientId;
    public $getDiagnosis;
    public $getReason;
    public $getFacility;
    public $getShoId;
    public $getTransferId;
    public $doctorslist = [];

    public $getodate;
    public $getRecordDate;

    public $getPosition;
    public $dats;
    public $department_id;

    public function updatedSearchPatient()
    {
        //$this->search_patient = '1010454';
        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;
        $this->recordDate = date('Y-m-d', strtotime($this->recordDate));

        $columns = ['dbo.hperson.hpercode', 'dbo.hperson.patlast', 'dbo.hperson.patfirst', 'dbo.hperson.patmiddle'];

        $this->get_patients = DB::connection('hospital')->table('dbo.hperson')
            ->join('dbo.herlog', 'dbo.hperson.hpercode', '=', 'dbo.herlog.hpercode')
            ->join('dbo.hencdiag', 'dbo.herlog.enccode', '=', 'dbo.hencdiag.enccode')
            ->select('dbo.hperson.patlast', 'dbo.hperson.patfirst', 'dbo.hperson.patmiddle', 'dbo.hperson.hpercode', 'dbo.herlog.erdate')
            ->where(function ($query) use ($columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $this->search_patient . '%')
                        ->whereNotNull('dbo.herlog.tscode')
                        ->whereNotNull('dbo.hencdiag.diagtext')
                        ->where('dbo.hencdiag.primediag', 'Y')
                        ->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 07:59:59']);
                }
            })->get();
        //dd($this->get_patients);
    }
    public function updatedSearchDoctor()
    {

        $columns = ['emp_id', 'lastname', 'firstname'];

        $this->get_doctors = HrisEmployee::select('emp_id', 'lastname', 'firstname')->where(function ($query) use ($columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $this->search_doctor . '%')
                    ->whereIn('department_id', $this->inc_depts)
                    ->whereIn('position_id', $this->position)
                    ->with('user');
            }
        })->get();
    }
    public function mount()
    {
        $date = date('Y-m-d H:i:s'); //take current date
        //$date = date('2024-01-02 17:00:00');
        $this->report_date = $date;
        //$this->getHospitalIds = Hospital::orderBy('hospital_name', 'asc')->get();
        $this->senior_house_officer = sprintf('%06d', Auth::user()->employee->emp_id); // get user emp_id, details for sho in charge
        $this->getPosition = Auth::user()->employee->position_id;
        //$this->getPosition = 18;
    }

    public function render()
    {

        $cur_time = Carbon::parse(now())->format('H');
        //$cur_time = 17;
        //dd($cur_time);
        $detail = ShoDetail::all()->last();
        $this->getShoDetail = $detail;
        $this->getCurrentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->report_date);
        $this->getDiffHours = $this->getCurrentDateTime->diffInHours($detail->report_date);
        $trasnferfroms = shoTransferFrom::select('sho_id', 'id', 'diagnosis', 'reason', 'facility', 'patient_id')->where('sho_id', $detail->id)->paginate(4, ['*'], 'trasnferfrom');
        $trasnsferTos = ShoTransferTo::select('sho_id', 'id', 'diagnosis', 'reason', 'facility', 'patient_id')->where('sho_id', $detail->id)->paginate(4, ['*'], 'trasnsferTo');
        $this->current_detail = $detail; //set the current detail of senior head officer
        $departments = HrisDepartment::select('department_id', 'department')->whereIn('department_id', $this->inc_depts)->where('division_id', '2')->get(); // take the department that belongs only in a specified dept, use for filtering data

        $this->recordDate = date('Y-m-d', strtotime($detail->report_date));
        $this->currentDate = date('Y-m-d', strtotime($this->report_date));
        $this->getTime = $cur_time;

        $this->getRecordDate = $this->recordDate;

        return view('livewire.pages.check-in', [
            'departments' =>  $departments ?? null,
            'detail' =>   $detail ?? null,
            'transfers' => $trasnferfroms ?? null,
            'trasnsferTos' => $trasnsferTos ?? null,
            'cur_time' => $cur_time,
            'getPatients' => $this->get_patients,
            'doctors' => $this->get_doctors,

        ]);
    }

    /*for adding Senior officer detail*/
    public function check_in_sho()
    {
        $this->validate([
            'senior_house_officer' => ['required', 'exists:hris.tbl_useraccount,emp_id'], //check the employee if really exist from the employe table
            'report_date' => ['required', 'unique:sho_details,report_date'],  //chech if the senior officer report is allready exist using the date it must be unique
        ]);
        $date = date('Y-m-d', strtotime($this->report_date));
        $dateTime = $date . ' 17:00:00';
        $detail = HrisEmployee::where('emp_id', $this->senior_house_officer)->whereIn('position_id', $this->position)->first();
        if ($detail) {

            ShoDetail::updateOrCreate([
                'employee_id' => sprintf('%06d', $this->senior_house_officer),
                'report_date' => $dateTime, //date('Y-m-d'),
            ]);
            $this->alert('success', 'Successfully Created!');
        } else {
            $this->alert('warning', 'You dont have permission to create report!');
        }
    }
    /* for adding medical officer and medical specialist detail*/
    public function check_in_mo($id)
    {
        //dd($this->get_doctors);
        $this->doctor_id = sprintf('%06d', $id);
        $this->validate([
            'current_detail' => ['required'],
            'doctor_id' => ['required', 'exists:hris.tbl_useraccount,emp_id'],
        ]);

        $dat = new DateTime($this->getShoDetail->report_date);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->recordDate = date('Y-m-d', strtotime($this->getShoDetail->report_date));

        $employee = HrisEmployee::where('emp_id', $this->doctor_id)->first(); //fetchin details in employees table, filtered by the doctor id enterd by the senior houese officer=

        $shomoduties = ShoMoDuty::where('employee_id', $this->doctor_id)->whereBetween('report_date', [$this->recordDate  . ' 17:00:00', $todate  . ' 11:59:59'])->first();
        if ($shomoduties) {
            $this->alert('warning', 'Already Added!');
            $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition', 'department_id');
        } else { // save the medical officer is not yet on duty
            ShoMoDuty::create([
                'sho_id' => $this->current_detail->id,
                'employee_id' => sprintf('%06d', $employee->emp_id),
                'department_id' =>  $this->department_id,
                'report_date' => $this->current_detail->report_date,
            ]);
            $this->alert('success', 'Successfully added!');
            $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition', 'department_id');
        }
    }

    public function check_in_ms($id)
    {
        $this->doctor_id = sprintf('%06d', $id);
        $this->validate([
            'current_detail' => ['required'],
            'doctor_id' => ['required', 'exists:hris.tbl_useraccount,emp_id'],
        ]);

        $employee = HrisEmployee::where('emp_id', $this->doctor_id)->first();

        // check if the Medical Specialist is already on duty
        $dat = new DateTime($this->getShoDetail->report_date);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->recordDate = date('Y-m-d', strtotime($this->getShoDetail->report_date));

        $shomsduties = ShoMsDuty::where('employee_id', $this->doctor_id)->whereBetween('report_date', [$this->recordDate  . ' 17:00:00', $todate  . ' 11:59:59'])->first();
        if ($shomsduties) {
            $this->alert('warning', 'Already Added!');
            $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition', 'department_id');
        } else {
            ShoMsDuty::create([
                'sho_id' => $this->current_detail->id,
                'employee_id' => sprintf('%06d', $employee->emp_id),
                'department_id' =>  $this->department_id,
                'report_date' => $this->current_detail->report_date,
            ]);
            $this->alert('success', 'Successfully Added!');
            $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition', 'department_id');
        }
    }
    // For searching patients
    public function get_patientIdFrom($id)
    {

        $this->patientFromId = sprintf('%06d', $id);
        //$this->recordDate = date('Y-m-d', strtotime($this->recordDate));
        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;

        $this->get_patient = HospitalHerlog::select('hpercode', 'enccode')->where('hpercode', $this->patientFromId)
            ->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 07:59:59'])
            ->whereNotNull('tscode')
            ->with('patient')->latest('erdate')->first();

        $this->selected_patient = $this->get_patient;

        $this->getDiag = $this->get_patient->diagnosis->first();
        if ($this->getDiag) {
            $this->diagnosis = $this->getDiag->diagtext;
        } else {
            $this->diagnosis = "No record found";
        }
        $this->reset('search_patient', 'patient');
    }
    // Get hospital list and get patient info
    public function shoTransferFrom($id)
    {
        //$this->getHospitalIds = Hospital::orderBy('hospital_name', 'asc')->get();
        $patient = HospitalPatient::find(sprintf('%06d', $id))->first();
        $this->selected_patient = $patient ?? null;
    }

    public function saveShoTransferFrom()    // Save transfer from info
    {
        $this->validate(
            [
                'reason' => ['required'],
                'facility' => ['required'],
                'diagnosis' => ['required'],

            ],
            [
                'reason.required' => '*',
                'facility.required' => '*',
            ]
        );
        $getTransferFrom = shoTransferFrom::where('patient_id', $this->patientFromId)->where('report_date', $this->getShoDetail->report_date)->first();
        //$getTransferTo = shoTransferTo::where('patient_id', $this->patientFromId)->where('report_date', $this->getShoDetail->report_date)->first();

        if ($getTransferFrom) // check if the the patient is already transfered
        {
            $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'get_option', 'search_patient', 'getPosition');
            $this->alert('warning', 'Patient Already Transfered!');
        } else {
            ShoTransferFrom::create([
                'patient_id' => sprintf('%06d', $this->patientFromId),
                'diagnosis' => $this->diagnosis,
                'reason' => $this->reason,
                'report_date' => $this->report_date,
                'facility' => $this->facility,
                'sho_id' => $this->current_detail->id,
            ]);
            $this->alert('success', 'Patient Transfered!');
            //return redirect()->route('checkin');
            $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'get_option', 'search_patient', 'getPosition');
        }
    }

    public function get_patientIdTo($id) // For searching patients
    {
        $this->patienToId = sprintf('%06d', $id);

        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;

        $this->get_patient = HospitalHerlog::select('hpercode', 'enccode')->where('hpercode', $this->patienToId)
            ->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 07:59:59'])
            ->whereNotNull('tscode')
            ->with('patient')->latest('erdate')->first();

        $this->selected_patient = $this->get_patient;
        $this->getDiag = $this->get_patient->diagnosis->first();
        if ($this->getDiag) {
            $this->diagnosis = $this->getDiag->diagtext;
        } else {
            $this->diagnosis = "No record found";
        }
        //$this->facility = "Mariano marcos memorial hospital medical center";
        $this->reset('search_patient', 'patient');
    }
    public function shoTransferTo() // Get hospital list and get patient info
    {
        //$this->getHospitalIds = Hospital::orderBy('hospital_name', 'asc')->get();
        $patient = Patient::find($this->patienToId);
        $this->selected_patient = $patient ?? null;
    }

    public function saveShoTransferTo()     // Save transfer from info
    {
        $this->validate(
            [
                'reason' => ['required'],
                'facility' => ['required'],
                'diagnosis' => ['required'],

            ],
            [
                'reason.required' => '*',
                'facility.required' => '*',
            ]
        );
        $getTransferTo = shoTransferTo::where('patient_id', $this->patienToId)->where('report_date', $this->getShoDetail->report_date)->first();


        if ($getTransferTo) // check if the the patient is already transfered
        {
            $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'get_option', 'search_patient', 'getPosition');
            $this->alert('warning', 'Patient Already Transfered');
        } else {
            shoTransferTo::create([
                'patient_id' => sprintf('%06d', $this->patienToId),
                'diagnosis' => $this->diagnosis,
                'reason' => $this->reason,
                'report_date' => $this->report_date,
                'facility' => $this->facility,
                'sho_id' => $this->current_detail->id,
            ]);
            $this->alert('success', 'Patient Transfered!');
            $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition');
        }
    }

    public function getDepartmenttId($getDeptID)
    {
        $this->department_id = $getDeptID;
    }

    // public function searchpatient()
    // {
    //     $dat = new DateTime($this->recordDate);
    //     $dat->modify('+1 day');
    //     $todate = $dat->format('Y-m-d');
    //     $this->recordDate = date('Y-m-d', strtotime($this->recordDate));
    //     //   $columns=['col1','col2','col3'];
    //     //   $items = Item::where(function($query)use($columns){
    //     //   foreach($columns as $column){
    //     //   $query->orWhere($column,'like','%active%')}
    //     //   })->get();
    //     $this->get_patients = DB::connection('hospital')->table('dbo.hperson')
    //         ->join('dbo.herlog', 'dbo.hperson.hpercode', '=', 'dbo.herlog.hpercode') // joining the
    //         ->join('dbo.hencdiag', 'dbo.herlog.enccode', '=', 'dbo.hencdiag.enccode')
    //         ->select('dbo.hperson.patlast', 'dbo.hperson.patfirst', 'dbo.herlog.hpercode', 'dbo.hencdiag.enccode', 'dbo.hencdiag.primediag')
    //         ->where($this->get_option, $this->search_patient)->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])
    //         ->where('dbo.hencdiag.primediag', 'Y')->get();
    // }

    public function deleteComfirmedMo($id)
    {
        $this->getId = $id;
        $moduty = ShoMoDuty::where('id', $this->getId)->first();
        $moduty->delete();
        $this->alert('success', 'Deleted');
        $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition');
    }
    public function deleteComfirmedMs($id)
    {
        $this->getId = $id;
        $msduty = ShoMsDuty::where('id', $this->getId)->first();
        $msduty->delete();
        $this->alert('success', 'Deleted');
        $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition');
    }

    public function editTransferFrom($transferId, $cDiagnosis, $cFacility, $cReason, $cpatientId, $cShoid)
    {
        $this->patientId = $cpatientId;
        $this->getDiagnosis = $cDiagnosis;
        $this->getReason = $cReason;
        $this->getFacility = $cFacility;
        $this->getShoId = $cShoid;
        $this->getTransferId = $transferId;

        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;
        //$this->recordDate = date('Y-m-d', strtotime($this->recordDate));
        $this->selected_patient = HospitalHerlog::where('hpercode', $this->patientId)->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 23:59:59'])->with('patient')->latest('erdate')->first();
    }
    public function editTransferTo($transferId, $cDiagnosis, $cFacility, $cReason, $cpatientId, $cShoid)
    {
        $this->patientId = $cpatientId;
        $this->getDiagnosis = $cDiagnosis;
        $this->getReason = $cReason;
        $this->getFacility = $cFacility;
        $this->getShoId = $cShoid;
        $this->getTransferId = $transferId;

        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;
        //$this->recordDate = date('Y-m-d', strtotime($this->recordDate));
        $this->selected_patient = HospitalHerlog::where('hpercode', $this->patientId)->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 23:59:59'])->with('patient')->latest('erdate')->first();
    }
    public function updateTranssferFrom()
    {
        $this->validate([
            'getDiagnosis' => ['required'],
            'getReason' => ['required'],
            'getFacility' => ['required']
        ]);

        $epdateTransferFrom = ShoTransferFrom::where('id', $this->getTransferId)->first();
        $epdateTransferFrom->patient_id = $this->patientId;
        $epdateTransferFrom->sho_id = $this->getShoId;
        $epdateTransferFrom->diagnosis = $this->getDiagnosis;
        $epdateTransferFrom->reason = $this->getReason;
        $epdateTransferFrom->facility = $this->getFacility;
        $epdateTransferFrom->save();
        $this->alert('success', 'Updated');
        $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition');
    }
    public function updateTranssferTo()
    {
        $this->validate([
            'getDiagnosis' => ['required'],
            'getReason' => ['required'],
            'getFacility' => ['required']
        ]);
        $epdateTransferTo = ShoTransferTo::where('id', $this->getTransferId)->first();
        $epdateTransferTo->patient_id = $this->patientId;
        $epdateTransferTo->sho_id = $this->getShoId;
        $epdateTransferTo->diagnosis = $this->getDiagnosis;
        $epdateTransferTo->reason = $this->getReason;
        $epdateTransferTo->facility = $this->getFacility;
        $epdateTransferTo->save();
        $this->alert('success', 'Updated');
        $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition');
    }
    public function reset_patient_from_to_id() //resets variables
    {
        $this->patientFromId = null;
        $this->patienToId = null;
        $this->selected_patient = null;
        $this->search_patient = null;
        $this->get_option = null;
        $this->search_doctor = null;
        $this->get_doctors = null;
    }
    public function deleteComfirmedTransferFrom($id)
    {
        $deleteShoTransferFrom = ShoTransferFrom::where('id', $id)->first();
        $deleteShoTransferFrom->delete();
        $this->alert('success', 'Deleted');
    }
    public function deleteComfirmedTransferTo($id)
    {
        $deleteShoTransferTo = ShoTransferTo::where('id', $id)->first();
        $deleteShoTransferTo->delete();
        $this->alert('success', 'Deleted');
    }
    public function refresh()
    {
        $this->resetExcept('report_date', 'current_detail', 'trasnferfrom', 'trasnsferTo', 'getHospitalIds', 'getPosition');
    }
    public function permission()
    {
        //dd('here');
        $this->dispatchBrowserEvent('warning');
    }
}
