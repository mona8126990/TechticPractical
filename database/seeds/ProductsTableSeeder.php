<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $data = array(
            array('name'=>'Aqua Fresh Omega skyland 18 L RO + UV + UF + TDS Water Purifier  (White-Red)','model_number'=>'Omega skyland','description'=>"Aquafresh ro system in india is a leader in uv water purification technology and has designed the Aquafresh online best water purifier system in india to meet demanding ISO 9001:2015 standards with the following features: award winning design: the Aquafresh ro water purifier system's award winning design with low price list in delhi ncr makes it the perfect solution to provide safe, pure water whenever and wherever needed, from the dinner table to your next camping adventure, you can be sure that your family's health is our first priority.",'price'=>5099,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()),
            array('name'=>'Syska SDI-07 1000 W Dry Iron  (White, Blue)','model_number'=>'SDI-07','description'=>"Syska Stellar Dry Iron with Golden American Heritage Soleplate is ideal for your daily ironing needs because of its sturdy, easy to clean, long-lasting structure and easy to use operation, perfect for all fabrics. It is an excellent choice if you are looking for a quick press every morning, be it for formal or casual wear.",'price'=>345,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()),
            array('name'=>'Inalsa QuickVac Dry Vacuum Cleaner with Reusable Dust Bag  (Red, Black)','model_number'=>'Dry Vacuum Cleaner','description'=>"Bring home this Inalsa vacuum cleaner that features a powerful 1000 W pure copper motor. It comes with attachments that make cleaning easy. The compact design and ergonomic handle make it easy to use this vacuum cleaner.",'price'=>7012,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()),
            array('name'=>'Microtek UPS SW EB1100 Pure Sine Wave Inverter Pure Sine Wave Inverter','model_number'=>'UPS SW EB1100','description'=>"OUTER BOX DIMENSIONS 23.5CM X 8CM X 16CM AND AFTER IT GETS ASSEMBELED 600MM X 318MM X 525MM, DIEMNSIONS ARE Luminous Tough-X Battery Trolley is an elegantly designed product, which is sturdy and yet, pleasing to the eye. It surely is the very best accessory for your Luminous Inverter batteries.",'price'=>15409,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()),
        );
        DB::table('products')->insert($data);
    }
}
