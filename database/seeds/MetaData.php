<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meta_data')->insert([
			[
				'meta_key'   => 'allow_amazon_popup',
				'meta_value' => 'true'
            ]
		]);
    }
}
