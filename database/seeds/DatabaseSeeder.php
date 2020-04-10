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
                'username' => 'superadmin',
                'name' => 'superadmin',
                'password' => bcrypt('5up3r'),
                'role' => 'superadmin',
                
            ],
            [
                'username' => 'admin',
                'name' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                
            ],
            [
                'username' => 'kasir',
                'name' => 'kasir',
                'password' => bcrypt('kasir'),
                'role' => 'staff',
                
            ],
            [
                'username' => 'user',
                'name' => 'user',
                'password' => bcrypt('user'),
                'role' => 'user',
                
            ],
        ]);

        DB::table('kategori')->truncate();
        DB::table('kategori')->insert([
            [
                'nama' => 'superadmin',
                'keterangan' => bcrypt('5up3r'),
                
            ],
            [
                'nama' => 'admin',
                'keterangan' => bcrypt('admin'),
                
            ],
            [
                'nama' => 'kasir',
                'keterangan' => bcrypt('kasir'),
                
            ],
        ]);
    }
}
