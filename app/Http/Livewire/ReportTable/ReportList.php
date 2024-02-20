<?php

namespace App\Http\Livewire\ReportTable;

use App\Models\Patient;
use Livewire\Component;
use App\Models\Operation;
use App\Models\ShoDetail;
use App\Models\Department;
use App\Models\ShoIncident;
use Livewire\WithPagination;
use App\Models\HospitalHerlog;
use Illuminate\Support\Carbon;
use App\Models\HospitalPatient;
use App\Models\HospitalTypesEr;
use App\Models\HrisDepartment;
use App\Models\HrisEmployee;
use Illuminate\Support\Facades\DB;
use App\Models\ShoSignificantEvent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use DateTime;
use Illuminate\Support\Facades\Auth;

class ReportList extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $listeners = ['deleteComfirmedOperation', 'fetchData', 'deleteComfirmedSignificant', 'deleteComfirmedIncident'];

    public $report_date;
    public $get_emp_id;
    public $getInfo;
    public $getMyId;
    public $catMyId;
    public $get_sho_detail;

    public $incident_description;

    public $getIncidentDescription;
    public $getIncidentId;

    public $nature_of_incident;
    public $place_of_incident;
    public $time_of_incident;
    public $date_of_incident;

    public $getNatureOfIncident;
    public $getPlaceOfIncident;
    public $getTimeOfIncident;
    public $getDateOfIncident;
    public $getsignifincantIncidentId;

    public $patient_id;
    public $operation_done;

    public $return_patient_id;
    public $get_patientId;
    public $get_patient;
    public $button = 0;
    public $department;
    public $getdivision = 8;
    public $getCount;
    public $i = 1;

    public $search_patient;
    public $patient;
    public $get_option;
    public $getPatient;
    public $selected_patient;
    public $selected_patient_operation;
    public $getDiffHours;
    public $getCurrentDateTime;
    protected $get_patients;
    public $recordDate;
    public $currentDate;
    public $getTime;

    public $get_operation;
    public $getOperationId;
    public $getDept;
    public $getShoId;
    public $dept_code = [
        'SURG',
        'GYNE',
        'PEDIA',
        'MED',
        'ANES',
        'OPHTH',
        'ENT',
        'FAMED',
        'ORTHO',
    ];

    public $operation;
    public $significanIncident;
    public $getodate;
    public $getPosition;

    public $chk_incident_case_reported;
    public $chk_absconding_patient_case_reported;
    public $chk_doa_patient_case_reported;
    public $chk_other_security_function;
    public $chk_trauma_patient_case_reported;

    public $incident_case_reported;
    public $absconding_patient_case_reported;
    public $doa_patient_case_reported;
    public $other_security_function;
    public $trauma_patient_case_reported;

    // public function updatedSearchPatient()
    // {
    //     $this->get_patient = HospitalHerlog::where('hpercode', $this->search_patient)->where(DB::raw('CONVERT(date, erdate)'), $this->report_date)->with('patient')->latest('erdate')->first();
    //     if ($this->get_patient) {
    //         $this->patient = $this->get_patient->patient;
    //     } else {
    //         $this->patient = null;
    //     }
    // }
    public function updatedSearchPatient()
    {
        //$this->recordDate = date('Y-m-d', strtotime($this->recordDate));
        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;

        // select('hpercode', 'patlast', 'patfirst')->
        $columns = ['dbo.hperson.hpercode', 'dbo.hperson.patlast', 'dbo.hperson.patfirst'];

        $this->get_patients = DB::connection('hospital')->table('dbo.hperson')
            ->join('dbo.herlog', 'dbo.hperson.hpercode', '=', 'dbo.herlog.hpercode')  //joining the
            ->join('dbo.hencdiag', 'dbo.herlog.enccode', '=', 'dbo.hencdiag.enccode')
            ->select('dbo.hperson.patlast', 'dbo.hperson.patfirst', 'dbo.hperson.hpercode', 'dbo.hencdiag.enccode', 'dbo.hperson.patmiddle', 'dbo.herlog.erdate')
            ->where(function ($query) use ($columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $this->search_patient . '%')
                        ->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 07:59:59'])
                        ->whereNotNull('dbo.herlog.tscode')
                        ->whereNotNull('dbo.hencdiag.diagtext')
                        ->latest('dbo.hencdiag.diagtext')
                        ->where('dbo.hencdiag.primediag', 'Y');
                }
            })->get();
    }
    public function mount()
    {
        $date = date('Y-m-d H:i:s');
        //$date = date('2023-01-02 17:00:00');
        $this->report_date = $date;
        $this->getPosition = Auth::user()->employee->position_id;
        $this->getPosition = 18;
    }
    public function render()
    {
        //$this->get_sho_detail = ShoDetail::where('report_date', $this->report_date)->first();
        $this->get_sho_detail = ShoDetail::all()->last();
        $cur_time = Carbon::parse(now())->format('H');
        $cur_time = 17;
        $this->getCurrentDateTime = Carbon::createFromFormat('Y-m-d H:s:i', $this->report_date);
        $this->getDiffHours = $this->getCurrentDateTime->diffInHours($this->get_sho_detail->report_date);

        $dat = new DateTime($this->get_sho_detail->report_date);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->recordDate = date('Y-m-d', strtotime($this->get_sho_detail->report_date));
        $this->getCount = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->count();
        $operations = Operation::select('id', 'patient_id', 'sho_id', 'operation_done', 'department')->where('sho_id', $this->get_sho_detail->id)->paginate(4, ['*'], 'operation');
        //$departments = Department::where('division_id', $this->getdivision)->get();
        $getdepartments = HospitalTypesEr::whereIn('tscode', $this->dept_code)->get();

        $incidents = ShoIncident::where('sho_id', $this->get_sho_detail->id)->get();
        $significanIncidents = ShoSignificantEvent::select('id', 'sho_id', 'patient_id', 'nature_of_incident', 'place_of_incident', 'time_of_incident', 'date_of_incident')->where('sho_id', $this->get_sho_detail->id)->paginate(4, ['*'], 'significanIncident');

        $this->recordDate = date('Y-m-d', strtotime($this->get_sho_detail->report_date));
        $this->currentDate = date('Y-m-d', strtotime($this->report_date));
        $this->getTime = $cur_time;

        return view('livewire.report-table.report-list', [
            // 'patients'=> $patients,
            'operations' => $operations ?? null,
            'detail' => $this->get_sho_detail ?? null,
            'incidents' => $incidents ?? null,
            'departments' => $departments ?? null,
            'significanIncidents' => $significanIncidents ?? null,
            'patients' => $this->get_patient ?? null,
            'cur_time' => $cur_time,
            'getdepartments' => $getdepartments ?? null,
            'getPatients' => $this->get_patients,
        ]);
    }

    public function save_incident() // Save incident reports
    {
        $chkIncident = ShoIncident::where('report_date', $this->get_sho_detail->report_date)->where('sho_id', $this->get_sho_detail->id)->first();
        if ($chkIncident) {
            $this->alert('warning', 'Already Created!');
            $this->resetExcept('report_date', 'getPosition');
        } else {

            ShoIncident::create([
                'incident_case_reported' => $this->incident_case_reported,
                'absconding_patient_case_reported' => $this->absconding_patient_case_reported,
                'doa_patient_case_reported' => $this->doa_patient_case_reported,
                'other_security_function' => $this->other_security_function,
                'trauma_patient_case_reported' => $this->trauma_patient_case_reported,
                'sho_id' => $this->get_sho_detail->id,
                'report_date' => $this->report_date,
            ]);
            $this->alert('success', 'Successfully Added!');
            $this->resetExcept('report_date', 'getPosition');
        }
    }

    public function get_patient_id($id) //
    {

        $this->patient_id = strval($id);
        $this->selected_patient_operation = HospitalPatient::where('hpercode', $this->patient_id)->first();
    }

    public function save_significant()
    {
        $this->validate([
            'patient_id' => ['required'],
            'nature_of_incident' => ['required'],
            'time_of_incident' => ['required'],
            'place_of_incident' => ['required'],
            'date_of_incident' => ['required'],

        ], [
            'nature_of_incident.required' => '*',
            'time_of_incident.required' => '*',
            'place_of_incident.required' => '*',
            'date_of_incident.required' => '*'
        ]);

        ShoSignificantEvent::create([
            'sho_id' => sprintf('%06d', $this->get_sho_detail->id),
            'patient_id' => sprintf('%06d', $this->patient_id),
            'nature_of_incident' => $this->nature_of_incident,
            'time_of_incident' => $this->time_of_incident,
            'place_of_incident' => $this->place_of_incident,
            'date_of_incident' => $this->date_of_incident,
            'report_date' => $this->report_date,
        ]);
        //$this->dispatchBrowserEvent('pop');
        $this->alert('success', 'Successfully Added!');
        $this->resetExcept('report_date', 'getPosition');
        //return redirect()->route('reports');
    }

    public function selectPatient($id)
    {
        $this->patient_id = sprintf('%06d', $id);

        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;

        $this->get_patient = HospitalHerlog::where('hpercode', $this->patient_id)
            ->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 07:59:59'])
            ->whereNotNull('tscode')->with('patient')->latest('erdate')->first();

        $this->selected_patient = $this->get_patient;
        $this->department = $this->get_patient->tscode;
        $this->reset('search_patient', 'patient');
    }
    public function save_operation() //Save operation
    {
        $this->validate([
            'patient_id' => ['required'],
            'operation_done' => ['required'],
            'report_date' => ['required'],
            'department' => ['required'],

        ], [
            'operation_done.required' => 'This is a required field...'
        ]);
        Operation::create([
            'patient_id' => $this->patient_id,
            'operation_done' => $this->operation_done,
            'report_date' => $this->report_date,
            'department' => $this->department,
            'sho_id' => $this->get_sho_detail->id,
        ]);
        $this->alert('success', 'Successfully Added!');
        $this->reset('search_patient', 'patient', 'get_option', 'selected_patient_operation', 'get_patients', 'selected_patient');
        //return redirect()->route('reports');
    }
    public function reset_page()
    {
        $this->resetExcept('report_date', 'getPosition');
        //$this->reset('search_patient', 'patient', 'get_option', 'selected_patient_operation', 'selected_patient', 'getIncidentDescription');
        $this->selected_patient_operation = null;
        $this->selected_patient = null;
        $this->search_patient = null;
        $this->get_option = null;
    }

    public function find_patient()
    {
        $this->validate([
            'patient_id' => ['required']
        ]);

        $getPatient = Operation::where('patient_id', $this->patient_id)->where('report_date', $this->report_date)->first();
        if ($getPatient) {
            $this->alert('warning', 'Patient Already In Operation');
        } else {
            $patient = Patient::find($this->patient_id);
            if ($patient) {
                $patient_info = Patient::where('id', $this->patient_id)->get();
                $this->get_patient = $patient_info;
                $this->button = 1;
            } else {

                $this->alert('warning', 'Patient Not found');
                $this->button = 0;
            }
            // $this->get_patient =$patient;
        }
    }
    public function searchpatient()
    {
        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        //$this->recordDate = date('Y-m-d', strtotime($this->recordDate));
        $get_patient = DB::connection('hospital')->table('dbo.hperson')
            ->join('dbo.herlog', 'dbo.hperson.hpercode', '=', 'dbo.herlog.hpercode') // joining the contacts table , where user_id and contapaon man hotspotct_user_id are same
            ->join('dbo.hencdiag', 'dbo.herlog.enccode', '=', 'dbo.hencdiag.enccode')
            ->select('dbo.hperson.patlast', 'dbo.hperson.patfirst', 'dbo.herlog.hpercode', 'dbo.hencdiag.enccode', 'dbo.hencdiag.primediag')
            ->where($this->get_option, $this->search_patient)->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('dbo.hencdiag.primediag', 'Y')->get();
        $this->get_patients = $get_patient;
    }
    public function editOperation($operationId, $operationDone, $patientId, $patientDept, $getShoId)
    {

        $this->getOperationId = $operationId;
        $this->patient_id = $patientId;
        $this->get_operation = $operationDone;

        $this->getDept = $patientDept;
        $this->getShoId = $getShoId;

        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;

        $this->get_patient = HospitalHerlog::where('hpercode', $this->patient_id)->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 07:59:59'])->with('patient')->latest('erdate')->first();

        $this->selected_patient = $this->get_patient;
        //dd($this->getDept);
    }
    //{{ $significanIncident->id }}','{{ $significanIncident->nature_of_incident }}','{{ $significanIncident->place_of_incident }}','{{ $significanIncident->time_of_incident }}','{{ $significanIncident->date_of_incident }}')
    public function editSignificantIncident($significanIncidentId, $gnature_of_incident, $gplace_of_incident, $gtime_of_incident, $gdate_of_incident, $gpatientId)
    {

        $this->getNatureOfIncident = $gnature_of_incident;
        $this->getPlaceOfIncident = $gplace_of_incident;
        $this->getTimeOfIncident = $gtime_of_incident;
        $this->getDateOfIncident = $gdate_of_incident;
        $this->getsignifincantIncidentId = $significanIncidentId;
        $this->patient_id = $gpatientId;

        $dat = new DateTime($this->recordDate);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->getodate = $todate;

        $this->get_patient = HospitalHerlog::where('hpercode', $this->patient_id)->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $this->getodate  . ' 07:59:59'])->with('patient')->latest('erdate')->first();

        $this->selected_patient = $this->get_patient;
        //dd($gpatientId);
    }
    public function editIncident($id, $gincident_case_reported, $gabsconding_patient_case_reported, $gdoa_patient_case_reported, $gother_security_function, $gtrauma_patient_case_reported)
    {
        $this->getIncidentId = $id;
        $this->incident_case_reported = $gincident_case_reported;
        $this->absconding_patient_case_reported = $gabsconding_patient_case_reported;
        //dd($gabsconding_patient_case_reported);
        $this->doa_patient_case_reported = $gdoa_patient_case_reported;
        $this->other_security_function = $gother_security_function;
        $this->trauma_patient_case_reported = $gtrauma_patient_case_reported;
    }
    public function upadateOperation()
    {
        $this->validate([
            'get_operation' => ['required']
        ]);
        $updateOperation = Operation::where('id', $this->getOperationId)->first();
        $updateOperation->patient_id = $this->patient_id;
        $updateOperation->sho_id = $this->getShoId;
        $updateOperation->operation_done = $this->get_operation;
        $updateOperation->department = $this->getDept;
        $updateOperation->save();
        $this->alert('success', 'Updated');
        $this->resetExcept('report_date', 'getPosition');
    }
    public function updateSignificantEvent()
    {
        $updateSignificantevent = ShoSignificantEvent::where('id', $this->getsignifincantIncidentId)->first();
        $updateSignificantevent->nature_of_incident = $this->getNatureOfIncident;
        $updateSignificantevent->place_of_incident = $this->getPlaceOfIncident;
        $updateSignificantevent->time_of_incident = $this->getTimeOfIncident;
        $updateSignificantevent->date_of_incident = $this->getDateOfIncident;
        $updateSignificantevent->save();
        $this->alert('success', 'Updated');
        $this->resetExcept('report_date', 'getPosition');
    }
    public function updateIncident()
    {
        // $this->validate([
        //     'incident_case_reported' => ['required'],
        //     'absconding_patient_case_reported' => ['required'],
        //     'doa_patient_case_reported' => ['required'],
        //     'other_security_function' => ['required'],
        //     'trauma_patient_case_reported' => ['required'],
        // ]);
        //dd($this->incident_case_reported);
        if ($this->incident_case_reported == '') {
            $this->incident_case_reported = 0;
        }
        if ($this->absconding_patient_case_reported == '') {
            $this->absconding_patient_case_reported = 0;
        }
        if ($this->doa_patient_case_reported == '') {
            $this->doa_patient_case_reported = 0;
        }
        if ($this->other_security_function == '') {
            $this->other_security_function = 0;
        }
        if ($this->trauma_patient_case_reported == '') {
            $this->trauma_patient_case_reported = 0;
        }
        $updateIncident = ShoIncident::where('id', $this->getIncidentId)->first();

        $updateIncident->incident_case_reported = $this->incident_case_reported;
        $updateIncident->absconding_patient_case_reported = $this->absconding_patient_case_reported;
        $updateIncident->doa_patient_case_reported = $this->doa_patient_case_reported;
        $updateIncident->other_security_function = $this->other_security_function;
        $updateIncident->trauma_patient_case_reported = $this->trauma_patient_case_reported;
        $updateIncident->save();
        $this->alert('success', 'Updated');
        $this->resetExcept('report_date', 'getPosition');
    }
    public function deleteComfirmedOperation($id)
    {
        $deleteOperation = Operation::where('id', $id)->first();
        $deleteOperation->delete();
        $this->alert('success', 'Deleted');
        $this->resetExcept('report_date', 'getPosition');
    }
    public function deleteComfirmedSignificant($id)
    {
        $deleteSignificant = ShoSignificantEvent::where('id', $id)->first();
        $deleteSignificant->delete();
        $this->alert('success', 'Deleted');
        $this->resetExcept('report_date', 'getPosition');
    }
    public function deleteComfirmedIncident($id)
    {
        $deleteIncident = ShoIncident::where('id', $id)->first();
        $deleteIncident->delete();
        $this->alert('success', 'Deleted');
        $this->resetExcept('report_date', 'getPosition');
    }

    public function clickMe()
    {
        $id = sprintf('%06d', $this->get_emp_id);
        $this->getInfo = HrisEmployee::where('emp_id', $id)->first();
        //dd($this->getInfo);
        if ($this->getInfo) {
            $this->getMyId = $this->getInfo->emp_id;
            //dd($this->getMyId);
            $this->dispatchBrowserEvent('pos', [$this->getMyId => 'Hello try Swal']);
        } else {
            $this->dispatchBrowserEvent('neg');
        }
    }

    public function fetchData()
    {
        dd($this->catMyId);
    }
}
