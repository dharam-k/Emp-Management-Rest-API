<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix'=>'api/employee'], function() use ($router){
    $router->get('allEmployeeDetails', 'EmployeeController@allEmployeeDetails');
    $router->get('filterBySalary/{salary}', 'EmployeeController@filterBySalaryEmp');
    $router->get('filterByEmpName/{name}', 'EmployeeController@filterByEmpName');
    $router->get('filterByEmpNumber/{number}', 'EmployeeController@filterByEmpNumber');
    $router->get('employeeDetail/{emp_id}', 'EmployeeController@employeeDetail');
});

$router->group(['middleware' => 'auth:api'],function() use ($router){
    $router->post('api/employee/addEmployee', 'EmployeeController@addEmployee');
});


$router->group(['prefix'=>'api/department'], function() use ($router){
    $router->get('/allDepartmentDetails', 'DepartmentController@allDepartmentsDetail');
    $router->get('/empNamByDepart/{departName}', 'DepartmentController@empNamByDepart');
});

Route::group(['prefix' => 'api'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('user-profile', 'AuthController@me');
});

