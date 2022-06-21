<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    //
    public function allDepartmentsDetail(){
        return Department::all('department_id','department_name');
    }

    public function empNamByDepart(Request $req, $departName){

         return DB::table('employees')
                ->join('departments', 'departments.department_id', '=' ,'employees.department_id')
                ->where('departments.department_name', '=', $departName)
                ->get(['first_name', 'last_name']);
    }
}
