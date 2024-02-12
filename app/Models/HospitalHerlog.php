<?php

namespace App\Models;

use App\Models\ShoTransferFrom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalHerlog extends Model
{
    use HasFactory;
    protected $connection = 'hospital', $table = 'dbo.herlog', $primaryKey = 'enccode', $keyType = 'string', $foreignKey = 'hpercode';

    public function diagnosis()
    {
        return $this->hasMany(HospitalHencdiag::class, 'enccode', 'enccode')->where('primediag', 'Y');
    }

    public function patient()
    {
        return $this->belongsTo(HospitalPatient::class, 'hpercode', 'hpercode');
    }

    public function age()
    {
        return $this->patage;
    }

    public function getDepartment()
    {
        return $this->belongsTo(HospitalTypesEr::class, 'tscode', 'tscode')->whereNotNull('tscode');
    }

    public function gerdescription()
    {
        return $this->belongsTo(HrisDepartment::class,);
    }
}
