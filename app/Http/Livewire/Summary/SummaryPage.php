<?php

namespace App\Http\Livewire\Summary;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Operation;
use App\Models\ShoDetail;
use App\Models\Department;
use App\Models\HospitalHerlog;
use Livewire\WithPagination;
use App\Models\shoTransferFrom;
use Illuminate\Support\Facades\DB;
use DateTime;

class SummaryPage extends Component
{
    use WithPagination;
    public $text = "0";
    public $get_sho_detail;
    public $getdivision = 8;
    public $medicineId = 12;
    public $getId;
    public $get_date;

    public $countmed = 0;
    public $countsurgery = 0;
    public $ob = 0;
    public $pedia = 0;
    public $anes = 0;
    public $optha = 0;
    public $ent = 0;
    public $famed = 0;
    public $ortho = 0;
    public $getCount = 0;

    public $getdepartments = [];
    public $deptCount = [];
    public $report_date;
    public $inc_depts = [
        'ANES',
        'blue',
        'PEDIA',
        'SURG',
        'ORTHO',
        'OPHTH',
        'GYNE',
        'MED',
        'FAMED',
        'ENT',
        'blue',
        'SURG',
        // 'OB',
    ];
    public $get_logs;
    public $recordDate;
    public $currentDate;
    public $getTime;
    public function mount()
    {
        $date = date('Y-m-d H:i:s'); //take current date
        //$date = date('2023-12-26 07:00:00');
        $this->report_date = $date;
    }

    public function render()
    {

        $this->get_sho_detail = ShoDetail::all()->last();
        $cur_time = Carbon::parse(now())->format('H');
        $cur_time = 17;
        $this->getId = $this->get_sho_detail->id;
        $this->get_date = $this->get_sho_detail->report_date;
        $departments = Department::where('division_id', $this->getdivision)->get();
        $trasnferfroms = shoTransferFrom::select('diagnosis', 'reason', 'facility', 'patient_id')->where('sho_id', $this->get_sho_detail->id)->paginate(40);

        $this->recordDate = date('Y-m-d', strtotime($this->get_sho_detail->report_date));
        $this->currentDate = date('Y-m-d', strtotime($this->report_date));
        $this->getTime = $cur_time;

        $dat = new DateTime($this->get_sho_detail->report_date);
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        $this->recordDate = date('Y-m-d', strtotime($this->get_sho_detail->report_date));
        //$this->recordDate = date('Y-m-d', strtotime('2023-12-26'));
        $this->countmed = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'MED')->count();
        $this->ent = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'ENT')->count();
        $this->countsurgery = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'SURG')->count();
        $this->ob = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'GYNE')->count();
        $this->pedia = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'PEDIA')->count();
        $this->anes = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'ANES')->count();
        $this->optha = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'OPHTH')->count();
        $this->famed = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'FAMED')->count();
        $this->ortho = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'ORTHO')->count();
        $this->getCount = HospitalHerlog::select('erdate')->whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->count();

        return view('livewire.summary.summary-page', [
            'departments' => $departments ?? null,
            'operations' => $operations ?? null,
            'transfers' => $trasnferfroms ?? null
        ]);
    }
}
