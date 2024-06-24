<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// delete all users
		DB::table('user')->delete();

		// insert users
		DB::table('users')->insert([
			[
				'first_name'        => 'Ahsan',
				'last_name'         => 'Sheikh',
				'email'             => 'ahsan@vimerson.com',
				'password'          => Hash::make('ahsan123'),
				'phone_number'		=> 'nan',
            ], [
				'first_name'        => 'Admin',
				'last_name'         => 'Admin',
				'email'             => 'admin@vimerson.com',
				'password'          => Hash::make('admin123'),
				'phone_number'		=> 'nan',
            ]			
		]);
    }
}
