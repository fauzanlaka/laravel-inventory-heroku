<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon; //เกี่ยวกับเวลา
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();

        $data = [
            'name' => 'Samsung Galaxy S21',
            'slug' => 'samsung-galaxy-s21',
            'description' => 'lorem ibsum ffa laskdfj lkadksfsi ljflskdfu flksneirh fsdlkjf',
            'price' => 19400.20,
            'image' => 'https://via.placeholder.com/800x600.png/008876?text=samsung',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        Product::create($data);

        // Product::factory(9999)->create();
        Product::factory(999)->create();

    }
}
