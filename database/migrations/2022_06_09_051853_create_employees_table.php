<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('employee_id');
            //$table->primary('employee_id');
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->date('hire_date');
            $table->integer('job_id');
            $table->decimal('salary',8,2);
            $table->integer('manager_id')->nullable();
            $table->integer('department_id')->nullable();
            // $table->foreign('job_id')->references('job_id')->on('jobs')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('manager_id')->references('employee_id')->on('employees');
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
