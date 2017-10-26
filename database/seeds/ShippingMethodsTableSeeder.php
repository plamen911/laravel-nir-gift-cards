<?php

use Illuminate\Database\Seeder;

class ShippingMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_methods')->delete();

        DB::table('shipping_methods')->insert([
            ['id' => 1, 'name' => 'Overnight', 'amount' => 25.00, 'position' => 1],
            ['id' => 2, 'name' => '2nd Day', 'amount' => 20.00, 'position' => 2],
            ['id' => 3, 'name' => 'Ground', 'amount' => 15.00, 'position' => 3],
            ['id' => 4, 'name' => 'International Shipping', 'amount' => 0.00, 'position' => 4],
        ]);
    }
}
