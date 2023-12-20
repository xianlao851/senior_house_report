<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

use App\Models\Employee;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    public $getEmail;
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {


        Validator::make($input, [
            'emp_id' => ['required', 'string', 'max:255', 'unique:users,emp_id', 'exists:employees,id'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $detail = Employee::where('id', $input['emp_id'])->first();

        return User::create([
            'emp_id' => $input['emp_id'],
            'email' => $detail->email,
            'password' => Hash::make($input['password']),
        ]);
    }
}
