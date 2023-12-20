<?php

namespace App\Models;

use App\Models\Hospital;
use App\Models\HospitalPatient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoTransferFrom extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'sho_transfer_froms', $primaryKey = 'patient_id', $keyType = 'string', $foreignkey = 'hpercode';

    protected $fillable = [
        'patient_id',
        'diagnosis',
        'reason',
        'report_date',
        'facility',
        'sho_id',
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
