<?php

use Illuminate\Database\Seeder;

class PaymentGatewayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_gateway')->delete();

        DB::table('payment_gateway')->insert([
            ['id' => 1, 'name' => 'merchant_id', 'value' => '417227771521', 'site' => 'SagePay'],
            ['id' => 2, 'name' => 'merchant_key', 'value' => 'I5T2R2K6V1Q3', 'site' => 'SagePay'],
            ['id' => 3, 'name' => 'developer_id', 'value' => 'W8yvKQ5XbvAn7dUDJeAnaWCEwA4yXEgd', 'site' => 'SagePay'],
            ['id' => 4, 'name' => 'developer_key', 'value' => 'iLzODV5AUsCGWGkr', 'site' => 'SagePay'],
            ['id' => 5, 'name' => 'test_ccard', 'value' => '4222222222222222', 'site' => 'SagePay']
        ]);
    }
}
