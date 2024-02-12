<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalCity extends Model
{
    use HasFactory;
    protected $connection = 'hospital', $table = 'dbo.hcity', $primaryKey = 'citycode', $keyType = 'string';
    public function cityName()
    {
        return $this->ctyname;
    }
}
