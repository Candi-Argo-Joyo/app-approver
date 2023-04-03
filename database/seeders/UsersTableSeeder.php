<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('password'),
            'role' => 'administrator',
            'is_mapping' => 'false',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
