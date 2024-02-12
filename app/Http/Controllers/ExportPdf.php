<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Operation;
use App\Models\ShoDetail;
use App\Models\ShoMoDuty;
use App\Models\ShoMsDuty;
use App\Models\Department;
use App\Models\ShoIncident;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\ShoTransferTo;
use App\Models\HospitalHerlog;
use App\Models\ShoTransferFrom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\ShoSignificantEvent;

class ExportPdf extends Controller
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

    public function printTwoPage($id)
    {
        $this->getid = $id;

        $detail = ShoDetail::where('id', $this->getid)->first(); //take the senior head officer details in the sho table that have beed checked in
        $trasnfers = shoTransferFrom::where('sho_id', $detail->id)->paginate(4, ['*'], 'trasnferfrom');
        $trasnsferTos = ShoTransferTo::where('sho_id', $detail->id)->paginate(4, ['*'], 'trasnsferTo');
        if ($detail) {
            $departments = Department::where('division_id', '8')->get(); // take the department that belongs only in a specified dept, use for filtering data
            $this->current_detail = $detail; //set the current detail of senior head officer
        }
        $this->get_date = $detail->report_date;
        $this->getCount = Operation::where('sho_id', $detail->id)->count();
        //$operations=Operation::where('record_date', $detail->sho_id)->paginate(5);
        $operations = Operation::where('sho_id', $detail->id)->paginate(5, ['*'], 'operation');
        $departments = Department::where('division_id', $this->getdivision)->get();
        $incidents = ShoIncident::where('sho_id', $detail->id)->get();
        $significanIncidents = ShoSignificantEvent::where('sho_id', $detail->id)->paginate(4, ['*'], 'significanIncident');
        /*----*/

        // for third page
        $this->getCount = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->count();
        $this->countmed = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'MED')->count();
        $this->countsurgery = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'SURG')->count();
        $this->ob = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'GYNE')->count();
        $this->pedia = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'PEDIA')->count();
        $this->anes = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'ANES')->count();
        $this->optha = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'OPHTH')->count();
        $this->ent = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'ENT')->count();
        $this->famed = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'FAMED')->count();
        $this->ortho = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), $this->get_date)->where('tscode', 'ORTHO')->count();


        $pdf = Pdf::loadView('livewire.print-out-pdf.print-two-page', [
            'departments' => $detail ? $departments : null,
            'detail' => $detail ?? null,
            'transfers' => $trasnfers ?? null,
            'trasnsferTos' => $trasnsferTos ?? null,
            'operations' => $operations ?? null,
            'incidents' => $incidents ?? null,
            'departments' => $departments ?? null,
            'significanIncidents' => $significanIncidents ?? null,
            'getid' => $this->getid ?? null,
            'getCount' => $this->getCount ?? null,
            'get_date' => $this->get_date,
            'text' => $this->text,
            'countmed' => $this->countmed,
            'countsurgery' => $this->countsurgery,
            'ob' => $this->ob,
            'pedia' => $this->pedia,
            'anes' => $this->anes,
            'optha' => $this->optha,
            'ent' => $this->ent,
            'famed' => $this->famed,
            'ortho' => $this->ortho,
        ]);
        return $pdf->download('shoreport.pdf');
    }
}
