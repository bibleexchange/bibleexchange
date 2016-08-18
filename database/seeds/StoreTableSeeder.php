<?php

use Illuminate\Database\Seeder;
use BibleExperience\Store;

class StoresTableSeeder extends Seeder {

    public function run()
    {
        DB::table('stores')->delete();

        Store::create(
		[
			'business_name' => 'Evernote',
			'class' => 'BibleExperience\BeSync\Api\Evernote'
		]);
    }

}