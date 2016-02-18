<?php

use Illuminate\Database\Seeder;
use BibleExchange\Entities\Store;

class StoresTableSeeder extends Seeder {

    public function run()
    {
        DB::table('stores')->delete();

        Store::create(
		[
			'business_name' => 'Evernote',
			'class' => 'BibleExchange\BeSync\Api\Evernote'
		]);
    }

}