<?php

namespace App\Models;

use App\Models\Barangay;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipality extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $primaryKey = "municipality_id";
    protected $table = "municipalities";

    public function barangay()
    {
        return $this->hasMany(Barangay::class, 'municipality_id', 'municipality_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }
}
