<?php

namespace App\Models;

use App\Models\Patient;
use App\Models\HospitalHerlog;
use App\Models\HospitalPatient;
use Illuminate\Database\Eloquent\Model;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operation extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "patient_id", $keyType = 'string';
    protected $fillable = [
        'patient_id',
        'sho_id',
        'operation_done',
        'record_date',
        'department',
    ];
    public function patient()
    {
        return $this->belongsTo(HospitalPatient::class, 'patient_id', 'hpercode');
    }
    public function getAge()
    {
        return $this->belongsTo(HospitalHerlog::class,  'patient_id', 'hpercode');
    }
    public function getPatientInfo()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
    public function count()
    {
        return $i = +1;
    }

    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
