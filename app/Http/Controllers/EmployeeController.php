<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class EmployeeController extends Controller
{


    public function allEmployeeDetails(){

        //Cache::put('employeeDetail', Employee::all(), $second=100);
        //Cache::put('employeeDetail', Employee::all(), now()->addMinutes(1));

        // Cache::remember('employeeDetail', 5, function () {
        //     return Employee::all();
        // });

        //return Cache::get('employeeDetail');

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
            'profile_pic' => 'mimes:jpeg,png,jpg|required',
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

    public function updateEmpProfilePic(Request $request, $id){

        $this->validate($request,[
            'profile_pic' => 'mimes:jpeg,png,jpg|required',
        ]);

        if( $request->hasFile('profile_pic') ) {
            $destinationPath = storage_path( 'app/public/profile_pic' );
            $file = $request->profile_pic;
            $fileName = time() . '.'.$file->clientExtension();
            $file->move( $destinationPath, $fileName );


            //$fileName = time().'_'.$req->file->getClientOriginalName();
        }

        if(Employee::where('employee_id', '=', $id)->exists()){
            DB::table('employees')
                ->where('employee_id', $id)
                ->update(['profile_pic' => $fileName]);

            return response()->json(['message'=> 'Profile Pic has been updated']);
        }else{
            return response()->json(['message'=> 'Employee ID does not exixts']);
        }
    }

}
