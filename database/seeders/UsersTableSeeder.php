<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(
            [
                'username' => 'admin1234',
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'user_role' => "admin",
                'password' => bcrypt('123456'),
                'registered_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
        \DB::table('users')->insert([
                'username' => 'test1234',
                'name' => 'test',
                'email' => 'test@gmail.com',
                'user_role' => "user",
                'password' => bcrypt('123456'),
                'registered_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
    }
}
