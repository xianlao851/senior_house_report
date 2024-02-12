<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barangay extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "barangay_id";
    protected $table = "barangays";
}
