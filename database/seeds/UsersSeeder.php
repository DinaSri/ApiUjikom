<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'dsh',
            'email' => 'dsh@gmail.com',
            'password' => bcrypt('rahasia'),
             'role' => 'admin',
             'provider_id' => '',
             'provider' => '',
        ]);
    }
}
