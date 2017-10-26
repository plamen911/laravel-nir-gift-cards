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
        DB::table('users')->delete();

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Admin', 'email' => 'ivanov@ivanovnewmedia.com', 'password' => bcrypt('Nantucket1'), 'remember_token' => 'VlK9n2JUEKQ6X3KYUrXakhMbWrwjryrPAQsbnRGnEKtmYTn0D3jcpojFtjpX', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }
}
