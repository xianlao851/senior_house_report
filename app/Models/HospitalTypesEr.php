<?php

namespace App\Models;

use Carbon\Carbon;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalTypesEr extends Model
{
    use HasFactory;
    protected $connection = 'hospital', $table = 'dbo.htypser', $primaryKey = 'tscode', $keyType = 'string';

    public  function deptName()
    {
        return $this->tsdesc;
    }
    public function getlogs($getDate)
    {
        $dat = new DateTime($getDate);
        $sdate = $dat->format('Y-m-d');
        $dat->modify('+1 day');
        $todate = $dat->format('Y-m-d');
        //$this->countmed = HospitalHerlog::whereBetween(DB::raw('erdate'), [$this->recordDate  . ' 17:00:00', $todate  . ' 07:59:59'])->where('tscode', 'MED')->count();
        return $this->hasMany(HospitalHerlog::class, 'tscode', 'tscode')->whereBetween(DB::raw('erdate'), [$sdate  . ' 17:00:00', $todate  . ' 07:59:59'])->get();
    }
}
