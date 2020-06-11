<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('locations')->truncate();
        \DB::table('locations')->insert(array(
            array(
                'origin' => '10.8,10.3',
                'destination' => '10.10,10.10',
                'status' => 0,
                'user_id' => 1,
            ),
            array(
                'origin' => '10.8,10.8',
                'destination' => '10.5,10.3',
                'status' => 1,
                'user_id' => 2,
            )
        ));
    }
}
