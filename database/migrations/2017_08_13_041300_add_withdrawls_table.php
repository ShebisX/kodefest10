<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWithdrawlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawls', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->double('amount');
            $table->double('cost')->default(2380);
            $table->string('account_number');
            //Foreing
            $table->foreign('account_number')->references('number')->on('accounts')->onDelete('cascade');
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
        Schema::dropIfExists('withdrawls');
    }
}
