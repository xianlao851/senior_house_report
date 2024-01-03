<?php

namespace App\Http\Livewire\CheckInTable;

use Livewire\Component;
use App\Models\Department;
use App\Models\ShoDetail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CheckInTableList extends Component
{
    use WithPagination;
    public $getPosition;
    public $reports;

    public function mount()
    {
        $this->getPosition = Auth::user()->employee->position_id;
        //$this->getPosition = 18;
    }
    public function render()
    {
        $shodetails = ShoDetail::orderBy('report_date', 'desc')->paginate(9, ['*'], 'reports');
        //dd($shodetails);
        return view('livewire.check-in-table.check-in-table-list', [
            'shodetails' => $shodetails,
        ]);
    }
}
