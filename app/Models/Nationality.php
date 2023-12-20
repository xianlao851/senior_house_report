<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    protected $primaryKey = "nationality_id";
    protected $table = "nationalities";

    public function nationalityName()
    {
        return $this->nationality;
    }
}
