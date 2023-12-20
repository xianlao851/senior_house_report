<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisEmployeeDtr extends Model
{
    use HasFactory;
    protected $connection = 'hris', $table = 'tbl_employee_dtr', $primaryKey = 'dtr_id';
}
