<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatacenterInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datacenter_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('temperature');
            $table->integer('humidity');
            $table->foreignId('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datacenter_infos');
    }
}
