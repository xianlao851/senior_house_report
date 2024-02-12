<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisDivision extends Model
{
    use HasFactory;
    protected $connection = 'hris', $table = 'tbl_division';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'division_id';
}
