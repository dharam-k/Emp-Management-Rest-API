<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
    	return [
    	    'first_name'=>$this->faker->name,
    	    'last_name'=>$this->faker->name,
    	    'email'=>$this->faker->email,
    	    'phone_number'=>$this->faker->phoneNumber,
    	    'hire_date'=>$this->faker->date,
    	    'hire_date'=>$this->faker->date,
    	    'job_id'=>$this->faker->id,
    	    'salary'=>$this->faker->number,
    	    'manager_id'=>$this->faker->id,
    	    'department_id'=>$this->faker->id,

    	];
    }
}
