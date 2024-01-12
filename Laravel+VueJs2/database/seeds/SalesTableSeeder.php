<?php
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: Alif Academy
 * Date: 06.05.2018
 * Time: 12:07
 */
class SalesTableSeeder
{
    public function run()
    {
        // create roles
        DB::table('sales')->insert([
            // 1 tot kto imeet dostup k adminke
            [
                'description' => 'admin',
                'charge' => '301',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ],
            // dlya razrabotchikov
        ]);
    }
}