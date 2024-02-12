<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalHencdiag extends Model
{
    use HasFactory;
    protected $connection = 'hospital', $table = 'dbo.hencdiag', $primaryKey = 'enccode', $keyType = 'string';

    // public function diagtext()
    // {
    //     return $this->diagtext;
    // }
}
