<?php

namespace App\Models;

use App\Models\Patient;
use App\Models\HospitalPatient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoSignificantEvent extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $keyType = 'string', $primarykey = 'id', $foreignKey = 'sho_id';
    protected $table = "sho_significant_events";
    protected $fillable = [
        'sho_id',
        'patient_id',
        'nature_of_incident',
        'place_of_incident',
        'time_of_incident',
        'date_of_incident',
        'report_date',
    ];

    public function patient()
    {
        //dd($get);
        return $this->belongsTo(HospitalPatient::class, 'patient_id', 'hpercode');
    }
}
