<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entity')->insert([
            'lat' => '-6.957729',
            'lng' => '107.657326',
            'radius' => 45,
        ]);
    }
}
