<?php

namespace App\Http\Livewire\CheckInTable;

use Livewire\Component;
use App\Models\Operation;
use App\Models\ShoDetail;
use App\Models\Department;
use App\Models\ShoIncident;
use App\Models\ShoTransferTo;
use App\Models\HospitalHerlog;
use App\Models\HospitalTypesEr;
use App\Models\shoTransferFrom;
use Illuminate\Support\Facades\DB;
use App\Models\ShoSignificantEvent;
use DateTime;

class ViewPrintList extends Component
{
    public $current_detail, $selected_patient, $patient_id;
    public $senior_house_officer, $report_date;
    public $doctor_id;
    public $diagnosis, $reason;
    public $hospital_id;

    public $getTrasnsferFrom;
    public $getTrasnsferTo;
    public $getHospitalIds;
    public $getdetail;

    public  $modetails;

    public $getdivision = 8;
    public $get_sho_detail;
    public $get_date;
    public $getCount;
    public $i = 1;

    public $shodetails;
    public $getid;

    public $text = "0";
    public $countmed;
    public $countsurgery;
    public $ob;
    public $pedia;
    public $anes;
    public $optha;
    public $ent;
    public $famed;
    public $ortho;
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
    public $get_logs;
    public $recordDate;
    public $currentDate;
    public $getTime;

    public function mount($id)
    {
        $this->getid = $id;
    }
    public function render()
    {
        $detail = ShoDetail::where('id', $this->getid)->first(); //take the senior head officer details in the sho table that have beed checked in
        $trasnfers = shoTransferFrom::where('sho_id', $detail->id)->get();
        $trasnsferTos = ShoTransferTo::where('sho_id', $detail->id)->get();
        if ($detail) {
            $departments = Department::where('division_id', '8')->get(); // take the department that belongs only in a specified dept, use for filtering data
            $this->current_detail = $detail; //set the current detail of senior head officer
        }
        $this->get_date = $detail->report_date;
        // $this->getCount = Operation::where('sho_id', $detail->id)->count();
        //$operations=Operation::where('record_date', $detail->sho_id)->paginate(5);
        $operations = Operation::where('sho_id', $detail->id)->get();
        $departments = Department::where('division_id', $this->getdivision)->get();
        $getdepartments = HospitalTypesEr::whereIn('tscode', $this->dept_code)->get();
        $incidents = ShoIncident::where('sho_id', $detail->id)->get();
        $significanIncidents = ShoSignificantEvent::where('sho_id', $detail->id)->get();
        /*----*/

        // for third page
        $dat = new DateTime($detail->report_date);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->recordDate = date('Y-m-d', strtotime($detail->report_date));

        $this->countmed = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'MED')->count();
        $this->ent = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'ENT')->count();
        $this->countsurgery = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'SURG')->count();
        $this->ob = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'GYNE')->count();
        $this->pedia = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'PEDIA')->count();
        $this->anes = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'ANES')->count();
        $this->optha = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'OPHTH')->count();
        $this->famed = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'FAMED')->count();
        $this->ortho = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'ORTHO')->count();
        $this->getCount = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate . ' 17:00:00', $todate  . ' 07:59:59'])->count();

        return view('livewire.check-in-table.view-print-list', [
            'departments' => $detail ? $departments : null,
            'detail' => $detail ?? null,
            'transfers' => $trasnfers,
            'trasnsferTos' => $trasnsferTos ?? null,
            'operations' => $operations ?? null,
            'incidents' => $incidents ?? null,
            'departments' => $departments ?? null,
            'significanIncidents' => $significanIncidents ?? null,
            'getdepartments' => $getdepartments ?? null,
        ]);
    }
}
