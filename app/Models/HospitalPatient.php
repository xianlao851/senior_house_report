<?php

namespace App\Models;

use App\Models\HospitalAdrress;
use App\Models\HospitalHencdiag;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTime;

class HospitalPatient extends Model
{
    use HasFactory;
    protected $connection = 'hospital', $table = 'dbo.hperson', $primaryKey = 'hpercode', $keyType = 'string';

    public function  herlog()
    {
        return $this->belongsTo(HospitalHerlog::class, 'hpercode', 'hpercode');
    }
    public function getLogs($getData)
    {
        //$date = date('2023-12-14 17:00:00');
        $dat = new DateTime($getData);
        $sdate = $dat->format('Y-m-d');
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        return $this->hasMany(HospitalHerlog::class, 'hpercode', 'hpercode')->whereBetween(DB::raw('erdate'), [$sdate  . ' 17:00:00', $todate  . ' 07:59:59'])->get();
    }
    public function getLog()
    {
        return $this->hasMany(HospitalHerlog::class, 'hpercode', 'hpercode')->get('hpercode');
    }
    public function patient()
    {
        return $this->belongsTo(HospitalPatient::class, 'hpercode', 'hpercode');
    }

    public function get_patient_name()
    {
        //return $this->belongsTo()
        if ($this->patmiddle) {
            return $this->patlast . ', ' . $this->patfirst . ' ' . $this->patmiddle;
        } else {
            return $this->patlast . ', ' . $this->patfirst;
        }
    }

    public function getAddress()
    {
        return $this->hasMany(HospitalAdrress::class, 'hpercode', 'hpercode')->latest('datemod');
    }
}
