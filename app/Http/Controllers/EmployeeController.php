<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{


    public function allEmployeeDetails(){
        return Employee::all();
    }

    public function filterBySalaryEmp(Request $req, $salary){

        return Employee::where('salary', '>', $salary)->get();

    }

    public function filterByEmpNumber(Request $req, $number){

        return Employee::where('phone_number', '=', $number)->get();

    }

    public function filterByEmpName(Request $req, $name){

         return Employee::where('first_name', 'like', '%'.$name.'%')
                          ->Orwhere('last_name', 'like', '%'.$name.'%')->get();

    }

    public function employeeDetail(Request $req, $emp_id){
        return DB::table('employees')
                ->join('departments','departments.department_id', '=' , 'employees.department_id')
                ->join('jobs', 'jobs.job_id', '=', 'employees.job_id')
                ->join('locations', 'locations.location_id', '=', 'departments.location_id')
                ->join('countries', 'countries.country_id', '=', 'locations.country_id')
                ->where('employees.employee_id', '=',  $emp_id)
                ->get(['employee_id','first_name', 'last_name', 'job_title', 'department_name', 'city', 'country_name']);
    }

    public function addEmployee(Request $request){

        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'profile_pic' => 'mimes:jpeg,bmp,png,jpg|required',
            'email' => 'required|string',
            'phone_number' => 'required|numeric',
            'hire_date' => 'required|string',
            'job_id' => 'required|numeric',
            'manager_id' => 'required|numeric',
            'salary' => 'required|numeric',
            'department_id' => 'required|numeric'
        ]);

        if( $request->hasFile( 'profile_pic' ) ) {
            $destinationPath = storage_path( 'app/public/profile_pic' );
            $file = $request->profile_pic;
            $fileName = time() . '.'.$file->clientExtension();
            $file->move( $destinationPath, $fileName );
        }
       
        
        Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'profile_pic'=>$fileName,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'hire_date' =>$request->hire_date,
            'job_id' =>$request->job_id,
            'salary' => $request->salary,
            'manager_id' => $request->manager_id,
            'department_id' => $request->department_id,
        ]);

        return response()->json(['message'=> 'Employee has been created']);
    }

}
