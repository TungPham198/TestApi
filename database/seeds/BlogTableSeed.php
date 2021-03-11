<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blogs')->insert([
            'name'=>'name',
            'des'=>'des nha'
        ]);
    }
}
