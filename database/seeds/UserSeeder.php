<?php

use Illuminate\Database\Seeder;
use App\User;
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
        User::create([
            'email' => 'ysfwicaksana@gmail.com',
            'password' => Hash::make('admin'),
            'nama' => 'Yusuf Eka Wicaksana',
            'level' => 'pegawai'
        ]);
    }
}
