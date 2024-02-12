<?php

namespace App\Models;

use App\Models\ShoMoDuty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Employee extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function  fullname()
    {
        if ($this->middlename) {
            return $this->lastname . ', ' . $this->firstname . ' ' . $this->middlename;
        } else {
            return $this->lastname . ', ' . $this->firstname;
        }
    }

    public function name()
    {
        // return $this->lastname . ', ' . $this->firstname . ' ' . $this->middlename;
        return $this->lastname;
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function get_mo()
    {
    }

    public function shomodetail()
    {
        return $this->hasMany(ShoMoDuty::class);
    }
}
