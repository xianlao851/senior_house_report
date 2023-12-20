<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoTransferTo extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "sho_transfer_tos", $primaryKey = 'patient_id', $keyType = 'string', $foreigKey = 'hpercode';

    protected $fillable = [
        'patient_id',
        'sho_id',
        'diagnosis',
        'reason',
        'report_date',
        'facility',
    ];

    public function getpatient()
    {
        return $this->belongsTo(HospitalPatient::class, 'patient_id', 'hpercode');
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public function getAge()
    {
        return $this->belongsTo(HospitalHerlog::class,  'patient_id', 'hpercode');
    }
}
