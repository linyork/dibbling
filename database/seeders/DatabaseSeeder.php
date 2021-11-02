<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->call(LikeTableSeeder::class);
        $this->call(ListTableSeeder::class);
        $this->call(RecordTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
