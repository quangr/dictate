<?php

use Illuminate\Database\Seeder;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('words')->insert([
            'word' => str_random(5),
            'userid' => str_random(6),
            'date' => '20180406',
        ]);
    }
}
