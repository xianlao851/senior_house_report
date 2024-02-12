<?php

namespace App\Models;

use App\Models\Patient;
use App\Models\Barangay;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientAddress extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "id";
    protected $fillable = [
        'province_id',
        'municipality_id',
        'barangay_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }
}
