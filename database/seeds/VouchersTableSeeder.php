<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VouchersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('vouchers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $data = array(
            array('name'=>'FLAT 50%','type'=>2,'discount'=>50,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()),
            array('name'=>'FLAT 5%','type'=>2,'discount'=>5,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()),
            array('name'=>'FLAT 100Rs','type'=>1,'discount'=>100,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()),
            array('name'=>'FLAT 250Rs','type'=>1,'discount'=>250,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()),
        );
        DB::table('vouchers')->insert($data);
    }
}
