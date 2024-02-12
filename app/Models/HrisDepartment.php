<?php

namespace App\Models;

use App\Models\Operation;
use App\Models\ShoMoDuty;
use App\Models\ShoMsDuty;
use App\Models\HrisDivision;
use App\Models\HrisEmployee;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HrisDepartment extends Model
{
    use HasFactory;

    protected $connection = 'hris', $table = 'tbl_department';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'department_id';

    public function division()
    {
        return $this->belongsTo(HrisDivision::class, 'division_id', 'division_id');
    }

    public function employees()
    {
        return $this->hasMany(HrisEmployee::class, 'department_id', 'department_id');
    }

    public function checked_in_mo($sho_id)
    {
        return $this->hasMany(ShoMoDuty::class, 'department_id')->where('sho_id', $sho_id);
    }

    public function checked_in_ms($sho_id)
    {
        return $this->hasMany(ShoMsDuty::class, 'department_id')->where('sho_id', $sho_id);
    }

    public function operation($id)
    {
        return $this->hasMany(Operation::class)->where('sho_id', $id);
    }

    public function getCount($id)
    {
        return $this->hasMany(Operation::class)->where('department_id', $id);
    }

    public function deptName()
    {
        return $this->department;
    }
    public function getlogs()
    {
        //dd($getData);
        return $this->hasMany(HospitalHerlog::class, 'tscode', 'tscode');
    }
}
