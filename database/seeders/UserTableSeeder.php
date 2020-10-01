<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('users')->insert([
            'name' => 'admin',
            'role' =>'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('dannyyol'),
            'remember_token' => ''
        ]);
    }
}
