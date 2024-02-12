<?php

namespace App\Models;

use App\Models\ShoMsDuty;
use App\Models\ShoIncident;
use App\Models\HrisEmployee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoDetail extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "id";
    protected $fillable = [
        'employee_id',
        'report_date',
    ];

    public function employee()
    {
        return $this->belongsTo(HrisEmployee::class, 'employee_id', 'emp_id');
    }

    public function medical_officers()
    {
        return $this->hasMany(ShoMoDuty::class);
    }

    public function medical_specialist()
    {
        return $this->hasMany(ShoMsDuty::class);
    }

    public function get_dept()
    {
        return $this->belongsTo(Department::class);
    }

    public function incident()
    {
        return $this->hasMany(ShoIncident::class, 'sho_id', 'emp_id');
    }
}
