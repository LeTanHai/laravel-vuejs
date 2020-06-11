<?php

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
        //
        \DB::table('users')->truncate();
        \DB::table('users')->insert(array(
            array(
                'name' => 'Le Tan Hai',
                'email' => 'letanhai.lth@gmail.com',
                'role_id' => 2,
                'password' => '$2y$10$lXRrB.j0I3m2ZeKV1dbB7uDlmaxDZyIA8x0reiNOW04LuX/TrDVfq', //password2019
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'name' => 'Admin',
                'email' => 'admin@testing.com',
                'role_id' => 1,
                'password' => '$2y$10$lXRrB.j0I3m2ZeKV1dbB7uDlmaxDZyIA8x0reiNOW04LuX/TrDVfq', //password2019
                'created_at' => date("Y-m-d H:i:s"),
            ),
        ));
    }
}
