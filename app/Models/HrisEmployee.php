<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisEmployee extends Model
{
    use HasFactory;
    protected $connection = 'hris', $table = 'tbl_employee', $primaryKey = 'emp_id';

    public function fullname()
    {
        return $this->lastname . ', ' . $this->firstname . ' ' . $this->middlename;
    }

    public function prof_name()
    {
        // return $this->lastname . ', ' . $this->firstname . ' ' . $this->middlename;
        return $this->prefix . ' ' . $this->lastname;
    }

    public function dtr()
    {
        return $this->hasMany(HrisEmployeeDtr::class, 'emp_id', 'emp_id');
    }
    public function name()
    {
        // return $this->lastname . ', ' . $this->firstname . ' ' . $this->middlename;
        return $this->lastname;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'emp_id', 'emp_id');
    }
}
