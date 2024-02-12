<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use App\Models\HrisEmployee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ShoMoDuty extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $fillable = [
        'sho_id',
        'employee_id',
        'department_id',
        'report_date',
    ];

    public function employee()
    {
        return $this->belongsTo(HrisEmployee::class, 'employee_id', 'emp_id');
    }
}
