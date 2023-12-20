<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisPosition extends Model
{
    use HasFactory;
    protected $connection = 'hris', $table = 'tbl_position';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'position_id';
}
