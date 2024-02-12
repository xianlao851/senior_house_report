<?php

namespace App\Models;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "departments";
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function checked_in_mo($sho_id)
    {
        return $this->hasMany(ShoMoDuty::class)->where('sho_id', $sho_id);
    }

    public function checked_in_ms($sho_id)
    {
        return $this->hasMany(ShoMsDuty::class)->where('sho_id', $sho_id);
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
}
