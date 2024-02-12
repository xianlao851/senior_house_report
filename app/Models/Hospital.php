<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "hospital_id";
    protected $table = "hospitals";

    public function transferfrom()
    {
        return $this->hasMany(ShoTransferFrom::class);
    }
}
