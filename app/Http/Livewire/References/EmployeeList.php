<?php

namespace App\Http\Livewire\References;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeList extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $employees = Employee::has('user')->has('position')
            ->where('id', 'LIKE', '%' . $this->search)
            ->paginate(20);

        return view('livewire.references.employee-list', [
            'employees' => $employees,
        ]);
    }
}
