<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalProvince extends Model
{
    use HasFactory;
    protected $connection = 'hospital', $table = 'dbo.hprov', $primaryKey = 'provcode', $keyType = 'string';

    public function provinceName()
    {
        return $this->provname;
    }
}
