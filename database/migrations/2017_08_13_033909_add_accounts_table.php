<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('number',10)->unique();
            $table->double('amount');
            $table->string('password', 4);
            $table->enum('type',['Current','Saving'])->defult('Current');
            $table->string('user_id');
            //Foreings
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary('number');
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
        Schema::dropIfExists('accounts');
    }
}
