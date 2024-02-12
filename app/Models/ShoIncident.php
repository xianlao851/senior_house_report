<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoIncident extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "id";
    protected $fillable = [
        'incident_case_reported',
        'absconding_patient_case_reported',
        'doa_patient_case_reported',
        'other_security_function',
        'trauma_patient_case_reported',
        'sho_id',
        'report_date',
    ];
}
