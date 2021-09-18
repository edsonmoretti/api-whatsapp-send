<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('whatsapptelephone');
            $table->string('api_token');
            $table->boolean('checkemail')->default(false);
            $table->string('imap_host')->nullable();
            $table->string('imap_port')->nullable();
            $table->string('imap_user')->nullable();
            $table->string('imap_password')->nullable();
            $table->text('onlyfrom')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('configurations');
    }
}
