<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalBarangay extends Model
{
    use HasFactory;
    protected $connection = 'hospital', $table = 'dbo.hbrgy', $primaryKey = 'brg', $keyType = 'string';

    public function barangayName()
    {
        return $this->bgyname;
    }
}
