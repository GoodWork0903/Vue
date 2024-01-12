<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_key', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('key_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->timestamps();

            //must have only one  Key
            $table->unique('key_id');
            $table->foreign('key_id')->references('id')
                ->on('keys')->onDelete('cascade');

            $table->foreign('employee_id')->references('id')
                ->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_key', function (Blueprint $table){
            $table->dropForeign('employee_key_employee_id_foreign');
            $table->dropForeign('employee_key_key_id_foreign');
        });

        Schema::dropIfExists('employee_key');
    }
}
