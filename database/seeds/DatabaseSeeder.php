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
		factory('App\Jobs', 1000)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
