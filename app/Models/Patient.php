<?php

namespace App\Models;

use App\Models\Province;
use App\Models\Operation;
use App\Models\Nationality;
use App\Models\PatientAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Patient extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $primaryKey = "id";
    protected $table = "patients";
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'suffix',
        'preffix',
        'alias',
        'gender',
        'birth_date',
        'patient_address_id',
        'contact_no',
        'birth_place',
        'civil_stat',
        'emp_stat',
        'ethnicity',
        'nationality',
        'religion',
        'blood_type',
        'entry_by',
        'record_date',
    ];

    public function address()
    {
        return $this->belongsTo(PatientAddress::class, 'patient_address_id', 'id');
    }
    public function get_patient_name()
    {
        //return $this->belongsTo()
        if ($this->middle_name) {
            return $this->last_name . ', ' . $this->first_name . ' ' . $this->middle_name;
        } else {
            return $this->last_name . ', ' . $this->first_name;
        }
    }

    public function patient_name_age()
    {

        // return $this->first_name. ' '.$this->last_name. ' / '.$this->age;
        if ($this->middle_name) {
            return $this->last_name . ', ' . $this->first_name . ' ' . $this->middle_name . ' / ' . $this->age;
        } else {
            return $this->last_name . ' ' . $this->first_name . ' / ' . $this->age;
        }
    }

    public function get_patient_info()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function sho_info()
    {
        return $this->belongsTo(Employee::class);
    }

    public function operation()
    {
        return $this->hasMany(Operation::class);
    }

    public function nationalities()
    {
        return $this->belongsTo(Nationality::class, 'nationality', 'nationality_id');
    }
}
