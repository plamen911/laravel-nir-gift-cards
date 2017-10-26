<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShippingMethodsTableSeeder::class);
        $this->call(DeliveryTypesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(PaymentGatewayTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
