<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'cpf' => '00000000000',
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('admin'),
        ]);
        DB::table('configurations')->insert([
            'user_id' => '1',
            'whatsapptelephone' => '5581982001303',
            'api_token' => \Illuminate\Support\Str::uuid(),
        ]);
        DB::table('configurations')->insert([
            'user_id' => '1',
            'whatsapptelephone' => '5581982001302',
            'api_token' => \Illuminate\Support\Str::uuid(),
        ]);
    }
}
