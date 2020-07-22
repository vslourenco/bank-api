<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'agency' => '135-x',
            'number' => 123,
        ]);
        DB::table('accounts')->insert([
            'agency' => '246-8',
            'number' => 1865,
        ]);
        DB::table('accounts')->insert([
            'agency' => '135-7',
            'number' => 2468,
        ]);
    }
}
