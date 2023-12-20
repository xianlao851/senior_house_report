<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoIncident extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "id";
    protected $fillable = [
        'incident_description',
        'sho_id',
        'report_date',
    ];
}
