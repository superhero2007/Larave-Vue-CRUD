<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete all record
        DB::table('users')->delete();

        DB::table('users')->insert([
            'name'          => 'Super Admin',
            'email'         => 'super.admin@outlook.com',
            'phonenumber'   => 12345,
            'image'         => 'https://placeimg.com/640/480/animals',
            'password'      => 'password',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name'          => 'Admin',
            'email'         => 'admin@outlook.com',
            'phonenumber'   => 23456,
            'image'         => 'https://placeimg.com/640/480/nature',
            'password'      => 'password',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name'          => 'User',
            'email'         => 'user@outlook.com',
            'phonenumber'   => 34567,
            'image'         => 'https://placeimg.com/640/480/arch',
            'password'      => 'password',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }
}
