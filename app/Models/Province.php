<?php

namespace App\Models;

use Faker\Provider\sv_SE\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "province_id";
    protected $table = "provinces";

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'province_id', 'province_id');
    }
}
