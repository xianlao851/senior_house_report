<?php

namespace App\Models;

use App\Models\HospitalCity;
use App\Models\HospitalBarangay;
use App\Models\HospitalProvince;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalAdrress extends Model
{
    use HasFactory;
    protected $connection = 'hospital', $table = 'dbo.haddr', $primaryKey = 'hpercode', $keyType = 'string';

    public function province()
    {
        return $this->belongsTo(HospitalProvince::class, 'provcode', 'provcode');
    }
    public function city()
    {
        return $this->belongsTo(HospitalCity::class, 'ctycode', 'ctycode');
    }
    public function barangay()
    {
        return $this->belongsTo(HospitalBarangay::class, 'brg', 'bgycode');
    }
}
