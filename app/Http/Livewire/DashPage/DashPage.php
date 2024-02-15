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

    protected $listeners = ['loadChart'];

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
        'PEDIA' => '#f2ee0c',
        'SURG' => '#04823d',
        'ORTHO' => '#90cdf4',
        'OPHTH' => '#ed783e',
        'GYNE' => '#f50fde',
        'MED' => '#2170a3',
        'FAMED' => '#c42163',
        'ENT' => '#f50a0a',
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
        'ORTHO',
        'OB',
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
    public $getCount = [];
    public $getColors = [];
    public $start;
    public $end;

    public $getDeptCount;
    public $getDept;
    public function mount()
    {
        //$this->get_date = Carbon::createFromFormat('Y', DB::raw('CONVERT(date, erdate)'));

        $this->date_filter = 'this_month';
        // $operations = DB::connection('hospital')->table('dbo.herlog')
        //     ->select([
        //         'tscode'
        //     ])->whereIn('tscode', $this->dept_code)->whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->get()->groupBy(function ($data) {
        //         return $data->tscode;
        //     });
        // foreach ($operations as $department => $values) {
        //     $this->getDept[] = $department;
        //     $this->getDeptCount[] = count($values);
        // }

        // $this->dispatchBrowserEvent('loadChart', $this->getDeptCount);
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
        $this->j = 0;
        $this->departments = [];
        $this->deptCount = [];
        $this->getDept = [];
        $this->getDeptCount = [];
        $this->getColors = [];
        // public $getDeptCount;
        // public $getDept;
        // $this->departments = null;
        // $this->deptCount = null;
        //$this->j = null;
        $this->dateFilter = $this->date_filter;

        if ($this->date_filter == 'today') {
            $patients = HospitalHerlog::select('erdate')->whereDate(DB::raw('CONVERT(date, erdate)'), Carbon::today())->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->whereNotNull('tscode')->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('H');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->where(DB::raw('CONVERT(date, erdate)'), Carbon::today())->get()->groupBy(function ($data) {
                    //->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('tscode', 'asc')->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $this->j = 0;
            $this->departments = [];
            $this->deptCount = [];
            $this->getColors = [];
            foreach ($operations as $department => $values) {
                $this->departments[] = $department;
                $this->deptCount[] = count($values);
                $this->getColors[] = $this->colors[$this->departments[$this->j]];
                $this->j++;
            }
            $this->dispatchBrowserEvent('loadChart', ['count' => $this->deptCount, 'deptname' => $this->departments, 'getcolors' => $this->getColors]);

            $tranfserfrom = ShoTransferFrom::select('created_at')->whereDate('created_at', Carbon::today())->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::select('created_at')->whereDate('created_at', Carbon::today())->whereYear('created_at', Carbon::now()->year)->count();
        } // this year
        if ($this->date_filter == 'this_year') {
            //$patients = HospitalHerlog::whereYear('erdate', Carbon::now()->year)->get()->groupBy(function ($data) {
            $patients = HospitalHerlog::select('erdate')->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode',
                    'erdate'
                ])->whereIn('tscode', $this->dept_code)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->whereNotNull('tscode')->orderBy('tscode', 'asc')->get()->groupBy(function ($data) {
                    //dd($data->tscode);
                    return $data->tscode;
                });

            $this->j = 0;
            $this->departments = [];
            $this->deptCount = [];
            $this->getColors = [];
            foreach ($operations as $department => $values) {
                $this->departments[] = $department;
                $this->deptCount[] = count($values);
                $this->getColors[] = $this->colors[$this->departments[$this->j]];
                $this->j++;
            }
            $this->dispatchBrowserEvent('loadChart', ['count' => $this->deptCount, 'deptname' => $this->departments, 'getcolors' => $this->getColors]);


            $tranfserfrom = ShoTransferFrom::select('created_at')->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::select('created_at')->whereYear('created_at', Carbon::now()->year)->count();
        } // this year
        if ($this->date_filter == 'this_week') {
            //$patients = Patient::whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get()->groupBy(function($data)
            $patients = HospitalHerlog::select('erdate')->whereBetween(DB::raw('CONVERT(date, erdate)'), [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                    return Carbon::parse($data->erdate)->format('M-d');
                });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereBetween(DB::raw('CONVERT(date, erdate)'), [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('tscode', 'asc')->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $this->j = 0;
            $this->departments = [];
            $this->deptCount = [];
            $this->getColors = [];
            foreach ($operations as $department => $values) {
                $this->departments[] = $department;
                $this->deptCount[] = count($values);
                $this->getColors[] = $this->colors[$this->departments[$this->j]];
                $this->j++;
            }
            $this->dispatchBrowserEvent('loadChart', ['count' => $this->deptCount, 'deptname' => $this->departments, 'getcolors' => $this->getColors]);


            $tranfserfrom = ShoTransferFrom::select('created_at')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::select('created_at')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereYear('created_at', Carbon::now()->year)->count();
        } //this week
        if ($this->date_filter == 'last_week') {
            $patients = HospitalHerlog::select('erdate')->whereBetween(DB::raw('CONVERT(date, erdate)'), [Carbon::now()->subWeek(), Carbon::now()])
                ->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                    return Carbon::parse($data->erdate)->format('M-d');
                });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereBetween(DB::raw('CONVERT(date, erdate)'), [Carbon::now()->subWeek(), Carbon::now()])->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('tscode', 'asc')->get()->groupBy(function ($data) {
                    return $data->tscode;
                });
            $this->j = 0;
            $this->departments = [];
            $this->deptCount = [];
            $this->getColors = [];
            foreach ($operations as $department => $values) {
                $this->departments[] = $department;
                $this->deptCount[] = count($values);
                $this->getColors[] = $this->colors[$this->departments[$this->j]];
                $this->j++;
            }
            $this->dispatchBrowserEvent('loadChart', ['count' => $this->deptCount, 'deptname' => $this->departments, 'getcolors' => $this->getColors]);


            $tranfserfrom = ShoTransferFrom::select('created_at')->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::select('created_at')->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->whereYear('created_at', Carbon::now()->year)->count();
        } //last week
        if ($this->date_filter == 'this_month') {
            $patients = HospitalHerlog::select('erdate')->whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M-d');
            });
            //dd(Carbon::now()->month);
            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('tscode', 'asc')->get()->groupBy(function ($data) {
                    return $data->tscode;
                });
            // $this->j = 0;
            // $this->departments = [];
            // $this->deptCount = [];
            // foreach ($operations as $department => $values) {
            //     $this->departments[] = $department;
            //     $this->deptCount[] = count($values);
            // }
            $this->dispatchBrowserEvent('thisloadChart');

            $tranfserfrom = ShoTransferFrom::select('created_at')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::select('created_at')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
        } //this month
        if ($this->date_filter == 'last_month') {
            $patients = HospitalHerlog::select('erdate')->whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->subMonth()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M-d');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereMonth(DB::raw('CONVERT(date, erdate)'), Carbon::now()->subMonth()->month)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->year)->orderBy('tscode', 'asc')->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $this->j = 0;
            $this->departments = [];
            $this->deptCount = [];
            $this->getColors = [];
            foreach ($operations as $department => $values) {
                $this->departments[] = $department;
                $this->deptCount[] = count($values);
                $this->getColors[] = $this->colors[$this->departments[$this->j]];
                $this->j++;
            }
            $this->dispatchBrowserEvent('loadChart', ['count' => $this->deptCount, 'deptname' => $this->departments, 'getcolors' => $this->getColors]);

            $tranfserfrom = ShoTransferFrom::select('created_at')->whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::select('created_at')->whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->year)->count();
        } // last month
        if ($this->date_filter == 'yesterday') {
            $patients = HospitalHerlog::select('erdate')->wheredate(DB::raw('CONVERT(date, erdate)'), Carbon::yesterday())
                ->orderBy('erdate', 'asc')->whereNotNull('tscode')->get()->groupBy(function ($data) {
                    return Carbon::parse($data->erdate)->format('H');
                });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode'
                ])->whereIn('tscode', $this->dept_code)->whereNotNull('tscode')->wheredate(DB::raw('CONVERT(date, erdate)'), Carbon::yesterday())
                ->orderBy('tscode', 'asc')->get()->groupBy(function ($data) {
                    return $data->tscode;
                });

            $this->j = 0;
            $this->departments = [];
            $this->deptCount = [];
            $this->getColors = [];
            foreach ($operations as $department => $values) {
                $this->departments[] = $department;
                $this->deptCount[] = count($values);
                $this->getColors[] = $this->colors[$this->departments[$this->j]];
                $this->j++;
            }
            $this->dispatchBrowserEvent('loadChart', ['count' => $this->deptCount, 'deptname' => $this->departments, 'getcolors' => $this->getColors]);


            $tranfserfrom = ShoTransferFrom::select('created_at')->wheredate('created_at', Carbon::yesterday())->whereYear('created_at', Carbon::now()->year)->count();
            $tranfserto = ShoTransferTo::select('created_at')->wheredate('created_at', Carbon::yesterday())->whereYear('created_at', Carbon::now()->year)->count();
        } // yesterday

        if ($this->date_filter == 'last_year') {
            $patients = HospitalHerlog::select('erdate')->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->subYear()->year)->orderBy('erdate', 'asc')->get()->groupBy(function ($data) {
                return Carbon::parse($data->erdate)->format('M');
            });

            $operations = DB::connection('hospital')->table('dbo.herlog')
                ->select([
                    'tscode',
                    'erdate'
                ])->whereIn('tscode', $this->dept_code)->whereYear(DB::raw('CONVERT(date, erdate)'), Carbon::now()->subYear()->year)->whereNotNull('tscode')->orderBy('tscode', 'asc')->get()->groupBy(function ($data) {
                    return $data->tscode;
                });


            $this->j = 0;
            $this->departments = [];
            $this->deptCount = [];
            $this->getColors = [];
            foreach ($operations as $department => $values) {
                $this->departments[] = $department;
                $this->deptCount[] = count($values);
                $this->getColors[] = $this->colors[$this->departments[$this->j]];
                $this->j++;
            }
            $this->dispatchBrowserEvent('loadChart', ['count' => $this->deptCount, 'deptname' => $this->departments, 'getcolors' => $this->getColors]);


            $tranfserfrom = ShoTransferFrom::select('created_at')->whereYear('created_at', Carbon::now()->subYear()->year)->count();
            $tranfserto = ShoTransferTo::select('created_at')->whereYear('created_at', Carbon::now()->subYear()->year)->count();
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
            $tranfserfrom = ShoTransferFrom::select('created_at')->whereBetween('created_at', [$this->start, $this->end])->count();
            $tranfserto = ShoTransferTo::select('created_at')->whereBetween('created_at', [$this->start, $this->end])->count();
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
        //dd($operations);
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
            $this->getColors[] = $this->colors[$this->departments[$this->j]];
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
        //$this->getCount = json_encode($this->deptCount);

        // public $getDeptCount;
        // public $getDept;


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
