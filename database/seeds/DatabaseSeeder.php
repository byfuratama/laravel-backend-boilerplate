<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'email' => 'superadmin',
                'name' => 'superadmin',
                'password' => bcrypt('5up3r'),
                
            ],
            [
                'email' => 'admin',
                'name' => 'admin',
                'password' => bcrypt('admin'),
                
            ],
            [
                'email' => 'kasir',
                'name' => 'kasir',
                'password' => bcrypt('kasir'),
                
            ],
        ]);
    }
}
