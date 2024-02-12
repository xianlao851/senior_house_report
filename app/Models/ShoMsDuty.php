<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoMsDuty extends Model
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
