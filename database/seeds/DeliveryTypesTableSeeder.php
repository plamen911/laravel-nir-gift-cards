<?php

use Illuminate\Database\Seeder;

class DeliveryTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_types')->delete();

        DB::table('delivery_types')->insert([
            ['id' => 1, 'name' => 'Physical Card', 'position' => 1],
            ['id' => 2, 'name' => 'E-certificate', 'position' => 2]
        ]);
    }
}
