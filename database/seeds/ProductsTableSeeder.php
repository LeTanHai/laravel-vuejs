<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('products')->truncate();
        \DB::table('products')->insert(array(
            array(
                'name' => 'IphoneX',
                'code' => 'DB114A',
                'location_new' => '10.8,10.3',
                'description' => 'Oder by HaiLT',
                'status' => 0,
                'pickup' => 0,
                'user_id' => 1,
                'location_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'name' => 'IphoneXS',
                'code' => 'DB115A',
                'location_new' => '10.8,10.3',
                'description' => 'Oder by HaiLT',
                'status' => 0,
                'pickup' => 0,
                'user_id' => 1,
                'location_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'name' => 'Iphone7Plus',
                'code' => 'DB116A',
                'location_new' => '10.8,10.3',
                'description' => 'Oder by HaiLT',
                'status' => 0,
                'pickup' => 0,
                'user_id' => 1,
                'location_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'name' => 'Iphone6s',
                'code' => 'DB117A',
                'location_new' => '10.8,10.3',
                'description' => 'Oder by HaiLT',
                'status' => 0,
                'pickup' => 0,
                'user_id' => 1,
                'location_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'name' => 'SamSungNote10Lite',
                'code' => 'SS4521',
                'location_new' => '10.8,10.8',
                'description' => 'Oder by SonTT',
                'status' => 0,
                'pickup' => 0,
                'user_id' => 2,
                'location_id' => 2,
                'created_at' => date("Y-m-d H:i:s"),
            ),
        ));
    }
}
