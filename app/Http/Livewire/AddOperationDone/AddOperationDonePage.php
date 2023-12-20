<?php
namespace App\Http\Livewire\Modals;
namespace App\Http\Livewire\AddOperationDone;

use App\Models\Operation;
use Livewire\Component;

class AddOperationDonePage extends Component
{
    public $getid;
    public $operation_done;
    public bool $show=true;
    public $report_date;
    public function mount($id)
    {
        //dd($id);
        $this->getid = $id;
        $date = date('Y-m-d'); //take current date
        $this->report_date = $date;

    }

    public function render()
    {
        return view('livewire.add-operation-done.add-operation-done-page');
    }

    public function save()
    {
       Operation::create([
        'patient_id' =>$this->getid,
        'operation_done' =>$this->operation_done,
       'record_date'=>$this->report_date,
       ]);
       return redirect()->route('reports');
    }

}
