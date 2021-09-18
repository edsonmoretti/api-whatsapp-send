<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf', 11)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        $user = new \App\User();
        $user->name = 'Edson Moretti';
        $user->cpf = '07900648470';
        $user->password = \Illuminate\Support\Facades\Hash::make('07900648470');
        $user->email = 'edsonmoretti@live.com';
        $user->admin = true;
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
