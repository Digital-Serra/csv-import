<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emails')->insert([
            'name'=>'Mauri',
            'email'=>'mauri870@gmail.com',
            'token'=>bin2hex(random_bytes(30)),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
        ]);
    }
}
