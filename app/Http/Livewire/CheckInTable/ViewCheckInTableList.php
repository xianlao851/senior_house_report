<?php

namespace App\Http\Livewire\CheckInTable;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Operation;
use App\Models\ShoDetail;
use App\Models\ShoMoDuty;
use App\Models\ShoMsDuty;
use App\Models\Department;
use App\Models\ShoIncident;
use Livewire\WithPagination;
use App\Models\ShoTransferTo;
use App\Models\HospitalHerlog;
use App\Models\HospitalTypesEr;
//use PDF;
use App\Models\ShoTransferFrom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\ShoSignificantEvent;
use DateTime;

class ViewCheckInTableList extends Component
{

    use WithPagination;

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
    public $getid;

    public $getdivision = 8;
    public $get_sho_detail;
    public $get_date;
    public $getCount;
    public $i = 1;

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

    public $date;
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
        $date = date('Y-m-d H:i:s'); //take current date
        //$date = date('2023-12-02 07:00:00');
        $this->report_date = $date;
    }

    public function render()
    {
        $detail = ShoDetail::where('id', $this->getid)->first(); //take the senior head officer details in the sho table that have beed checked in
        $trasnferfroms = shoTransferFrom::where('sho_id', $detail->id)->paginate(4, ['*'], 'trasnferfrom');
        $trasnsferTos = ShoTransferTo::where('sho_id', $detail->id)->paginate(4, ['*'], 'trasnsferTo');
        if ($detail) {
            $departments = Department::where('division_id', '8')->get(); // take the department that belongs only in a specified dept, use for filtering data
            $this->current_detail = $detail; //set the current detail of senior head officer
        }
        $this->get_date = $detail->report_date;
        $cur_time = Carbon::parse(now())->format('H');
        //$cur_time = 7;

        $operations = Operation::where('sho_id', $detail->id)->paginate(5, ['*'], 'operation');
        $departments = Department::where('division_id', $this->getdivision)->get();
        $getdepartments = HospitalTypesEr::whereIn('tscode', $this->dept_code)->get();
        $incidents = ShoIncident::where('sho_id', $detail->id)->get();
        $significanIncidents = ShoSignificantEvent::where('sho_id', $detail->id)->paginate(4, ['*'], 'significanIncident');
        /*----*/

        $dat = new DateTime($detail->report_date);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->recordDate = date('Y-m-d', strtotime($detail->report_date));
        $this->getTime = $cur_time;

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


        return view('livewire.check-in-table.view-check-in-table-list', [
            'departments' => $detail ? $departments : null,
            'detail' => $detail ?? null,
            'transfers' => $trasnferfroms ?? null,
            'trasnsferTos' => $trasnsferTos ?? null,
            'operations' => $operations ?? null,
            'incidents' => $incidents ?? null,
            'departments' => $departments ?? null,
            'significanIncidents' => $significanIncidents ?? null,
            'getdepartments' => $getdepartments ?? null,
        ]);
    }

    // public function print_two()
    // {

    //     $detail = ShoDetail::where('id', $this->getid)->first(); //take the senior head officer details in the sho table that have beed checked in

    //     $transfers = shoTransferFrom::where('sho_id', $detail->id)->paginate(8);
    //     $trasnsferTos = ShoTransferTo::where('sho_id', $detail->id)->paginate(8);


    //     if ($detail) {
    //         $departments = Department::where('division_id', '8')->get(); // take the department that belongs only in a specified dept, use for filtering data
    //         $this->current_detail = $detail; //set the current detail of senior head officer
    //     }
    //     /*----*/
    //     $detail = ShoDetail::where('id', $this->getid)->first();
    //     $this->get_date = $detail->report_date;
    //     $this->getCount = Operation::where('sho_id', $detail->id)->count();
    //     $operations = Operation::where('sho_id', $detail->id)->paginate(5);
    //     $departments = Department::where('division_id', $this->getdivision)->get();
    //     $incidents = ShoIncident::where('sho_id', $detail->id)->get();
    //     $significanIncidents = ShoSignificantEvent::where('sho_id', $detail->id)->paginate(7);
    //     /*----*/

    //     $pdf = Pdf::loadView('livewire.check-in-table.view-check-in-table-list', [
    //         'departments' => $detail ? $departments : null,
    //         'detail' => $detail ?? null,
    //         'transfers' => $transfers ?? null,
    //         'trasnsferTos' => $trasnsferTos ?? null,
    //         'operations' => $operations ?? null,
    //         'incidents' => $incidents ?? null,
    //         'departments' => $departments ?? null,
    //         'significanIncidents' => $significanIncidents ?? null,
    //     ]);
    //     dd($pdf);
    //     return $pdf->download('TWO.pdf');
    // }
}
