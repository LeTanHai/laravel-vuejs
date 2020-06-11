<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->truncate();

        \DB::table('roles')->insert(array(
            array(
                // 'id' => 1,
                'name' => 'Admin',
                'description' => "Description about Admin",
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                // 'id' => 2,
                'name' => 'User',
                'description' => "Description about User",
                'created_at' => date("Y-m-d H:i:s"),
            )
        ));
    }
}
