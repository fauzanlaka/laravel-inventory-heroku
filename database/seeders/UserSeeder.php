<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ลบข้อมูลเก่าออกก่อน
        DB::table('users')->delete();

        $data = [
            'fullname' => 'fauzan yohtae',
            'username' => 'fauzan',
            'email' => 'fauzanlk@gmail.com',
            'password' => Hash::make('70632537'),
            'tel' => '0936925058',
            'avatar' => 'https://via.placeholder.com/400x400.png/005429?text=udses',
            'role'  => '1',
            'remember_token' => 'XMdJJjffie'
        ];

        User::create($data);

        // User::factory(99)->create();

        User::factory(49)->create();

        
    }
}
