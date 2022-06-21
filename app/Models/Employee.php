<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //

    protected $primaryKey = 'employee_id';

    protected $fillabel = ['first_name','last_name','profile_pic','email','phone_number','hire_date','job_id','salary', 'manager_id','department_id'];

    protected $fillable =  ['first_name','last_name','profile_pic','email','phone_number','hire_date','job_id','salary', 'manager_id','department_id'];


    
}
