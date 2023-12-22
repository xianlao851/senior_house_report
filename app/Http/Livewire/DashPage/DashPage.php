<?php

namespace App\Http\Livewire\DashPage;

use App\Models\Department;
use App\Models\HospitalHerlog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Patient;
use Livewire\Component;
use App\Models\Operation;
use App\Models\ShoTransferTo;
use App\Models\ShoTransferFrom;
use PHPUnit\Framework\Constraint\Operator;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Facades\LivewireAreaChart;

class DashPage extends Component
{
    public $val = 'sample';
    public $patientCount;

    public $i = 0;
    public $j = 0;
    public $k = 0;

    public $colors = [
        // 'Pediatrics Department' => '#7210e3',
        // 'Surgery Department' => '#fc8181',
        // 'Orthopedics Department' => '#90cdf4',
        // 'Ophthalmology Department' => '#66DA26',
        // 'OB-Gyne Department' => '#e3106b',
        // 'Internal Medicine' => '#2170a3',
        // 'Family Medicine' => '#c42163',
        // 'ENT-HNS Department' => '#28756c',
        // 'Anesthesiology Department' => '#e6f51b',
        'ANES' => 'e6f51b',
        'blue' => '#7210e3',
        'PEDIA' => '#7210e3',
        'SURG' => '#fc8181',
        'ORTHO' => '#90cdf4',
        'OPHTH' => '#66DA26',
        'GYNE' => '#e3106b',
        'MED' => '#2170a3',
        'FAMED' => '#c42163',
        'ENT' => '#28756c',
        'Anesthesiology Department' => '#e6f51b',
        'blue' => '#7210e3',
        // 'Surgery' => '#66DA26',
        'OB' => '#91147d',
        'NB' => '#143559',
        // 'pedia' => '#7210e3',
        // 'Orthopedics' => '#a3281f',
        // 'Pediatrics' => '#1d5227',
        // 'Obstetrics' => '#266e65'

    ];
    public $colors2 = [
        'Jan' => '#7210e3',
        'Feb' => '#fc8181',
        'Mar' => '#90cdf4',
        'Apr' => '#66DA26',
        'May' => '#e3106b',
        'Jun' => '#2170a3',
        'Jul' => '#c42163',
        'Aug' => '#28756c',
        'Sept' => '#e6f51b',
        'Oct' => '#6b910a',
        'Nov' => '#1080e3',
        'Dec' => '#38f5d9',

    ];
    public $dept_code = [
        'SURG',
        'GYNE',
        'PEDIA',
        'MED',
        'ANES',
        'OPHTH',
        'ENT',
        'FAMED',
        'ORTHO'
        // 'OB',
    ];
    public $get_date;
    public $date_filter;
    public $dateFilter;

    public $months = [];
    public $monthCount = [];
    public $days = [];
    public $dayCount = [];
    public $departments = [];
    public $deptCount = [];
    public $start;
    public $end;

    public function mount()
    {
        //$this->get_date = Carbon::createFromFormat('Y', DB::raw('CONVERT(date, erdate)'));

        $this->date_filter = 'this_year';
    }
    public function render()
    {

        //$patients =Patient::select('id','created_at')->get()->groupBy(function($data){
        // $patients =Patient::whereYear('created_at',Carbon::now()->year)->get()->groupBy(function($data)
        //dd(Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now()));

        $this->i = 0;
        $this->months = null;
        $this->monthCount = null;
        $this->days = null;
        $this->dayCount = null;
        // $this->departments = null;
        // $this->deptCount = null;
        // $this->j = null;
        $this->dateFilter = $this->date_filter;

        if ($this->date_filter == 'today') {
            $patients = HospitalHerlog::whereDate(DB::raw('CONVERT(date, erdate)'), Carbon::today())->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M-d');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->where(DB::raw('CONVERT(date, erdate)'), Carbon::today())->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $tranfserfrom = ShoTransferFrom::whereDate('created_at', Carbon::today())->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::whereDate('created_at', Carbon::today())->whereYear('created_at', Carbon::now()->year)->count();
        } // this year
        if ($this->date_filter == 'this_year') {
            //$patients = HospitalHerlog::whereYear('erdate', Carbon::now()->year)->get()->groupBy(function ($data) {
            $patients = HospitalHerlog::whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode',
                    'erdate'
                ])->whereIn('tscode', $this->dept_code)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->whereNotNull('tscode')->get()->groupBy(function ($data) {
                    //dd($data->tscode);
                    return $data->tscode;
                });

            $tranfserfrom = ShoTransferFrom::whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::whereYear('created_at', Carbon::now()->year)->count();
        } // this year
        if ($this->date_filter == 'this_week') {
            //$patients = Patient::whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get()->groupBy(function($data)
            $patients = HospitalHerlog::whereBetween(DB::raw('CONVERT(date, erdate)'), [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M-d');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereBetween(DB::raw('CONVERT(date, erdate)'), [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $tranfserfrom = ShoTransferFrom::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereYear('created_at', Carbon::now()->year)->count();
        } //this week
        if ($this->date_filter == 'last_week') {
            $patients = HospitalHerlog::whereBetween(DB::raw('CONVERT(date, erdate)'), [Carbon::now()->subWeek(), Carbon::now()])->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M-d');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereBetween(DB::raw('CONVERT(date, erdate)'), [Carbon::now()->subWeek(), Carbon::now()])->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
                    return $data->tscode;
                });
            $tranfserfrom = ShoTransferFrom::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->whereYear('created_at', Carbon::now()->year)->count();
        } //last week
        if ($this->date_filter == 'this_month') {
            $patients = HospitalHerlog::whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M-d');
            });
            //dd(Carbon::now()->month);
            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $tranfserfrom = ShoTransferFrom::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
        } //this month
        if ($this->date_filter == 'last_month') {
            $patients = HospitalHerlog::whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->subMonth()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M-d');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->subMonth()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $tranfserfrom = ShoTransferFrom::whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->year)->count();
        } //last month
        if ($this->date_filter == 'yesterday') {
            $patients = HospitalHerlog::wheredate('erdate', Carbon::yesterday())->orderBy('erdate', 'asc')->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M-d');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->wheredate(DB::raw('CONVERT(date, erdate)'), Carbon::yesterday())->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $tranfserfrom = ShoTransferFrom::wheredate('created_at', Carbon::yesterday())->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::wheredate('created_at', Carbon::yesterday())->whereYear('created_at', Carbon::now()->year)->count();
        } // yesterday

        if ($this->date_filter == 'last_year') {
            $patients = HospitalHerlog::whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->subYear()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode',
                    'erdate'
                ])->whereIn('tscode', $this->dept_code)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->subYear()->year)->whereNotNull('tscode')->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $tranfserfrom = ShoTransferFrom::whereYear('created_at', Carbon::now()->subYear()->year)->count();
            $tranfserto = ShoTransferTo::whereYear('created_at', Carbon::now()->subYear()->year)->count();
        } //last year
        if ($this->date_filter == 'define') {
            $patients = DB::connection('hospital')->table('dbo.herlog')
                ->whereBetween(DB::raw('CONVERT(date, erdate)'), [$this->start, $this->end])->get()->groupBy(function ($data) {
                    return Carbon::parse($data->erdate)->format('M-d');
                });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->whereBetween(DB::raw('CONVERT(date, erdate)'), [$this->start, $this->end])->get()->groupBy(function ($data) {
                    return $data->tscode;
                });
            $tranfserfrom = ShoTransferFrom::whereBetween('created_at', [$this->start, $this->end])->count();
            $tranfserto = ShoTransferTo::whereBetween('created_at', [$this->start, $this->end])->count();
            $this->reset('start', 'end');
        }
        //Start, line chart for patient count
        //Start, lineChartmodel for this_year and last_year filter
        if ($this->date_filter == 'this_year' || $this->date_filter == 'last_year') {
            $lineChartModel = (new LineChartModel())
                ->setAnimated(true)
                //->setTitle('Total Patient Count')
                ->withDataLabels();
            foreach ($patients as $month => $values) {
                $this->months[] = $month;
                $this->monthCount[] = count($values);
                $lineChartModel->addPoint($this->months[$this->i], $this->monthCount[$this->i], $this->colors['blue']);
                $this->i++;
            }
        } // End, lineChartmodel for this_year and last_year filter

        // Start lineChartmodel for filter this_week, last_week, yesterday, last_month, this_month and today
        if ($this->date_filter == 'this_week' || $this->date_filter == 'last_week' || $this->date_filter == 'yesterday' || $this->date_filter == 'last_month' || $this->date_filter == 'this_month' || $this->date_filter == 'today' || $this->dateFilter == 'define') {
            $lineChartModel = (new LineChartModel())
                ->setAnimated(true)
                //->setTitle('Total Patient Count')
                ->withDataLabels();
            foreach ($patients as $day => $values) {
                $this->days[] = $day;
                $this->dayCount[] = count($values);
                $lineChartModel->addPoint($this->days[$this->i], $this->dayCount[$this->i], $this->colors['blue']);
                $this->i++;
            }
        } // End lineChartmodel for filter this_week, last_week, yesterday, last_month, this_month and today
        //End, line chart for patient count

        //Start, column chart for patient count on operations group by department
        $columnChartModel = (new ColumnChartModel())
            ->withoutLegend()
            ->setAnimated(true);
        //->setTitle('Patient Per Department')
        //->withDataLabels();
        foreach ($operations as $department => $values) {
            $this->departments[] = $department;
            $this->deptCount[] = count($values);
            $columnChartModel->addColumn($this->departments[$this->j], $this->deptCount[$this->j], $this->colors[$this->departments[$this->j]]);
            $this->j++;
        } //End,  column chart for patient count on operations group by department

        //Start, pie chart,for transfers
        $pieChartModel = (new PieChartModel())
            //->setTitle('Patient Transfers')
            ->withDataLabels()
            ->setAnimated(true)
            ->addSlice('Transfer From', $tranfserfrom, '#2170a3')
            ->addSlice('Transfer To', $tranfserto, '#28756c');
        //End, pie chart,for transfers
        return view('livewire.dash-page.dash-page', [
            'pieChartModel' => $pieChartModel ?? null,
            'lineChartModel' => $lineChartModel ?? null,
            'columnChartModel' => $columnChartModel ?? null,

        ]);
    }

    public function clk()
    {
        $this->dateFilter = $this->date_filter;
    }
}
