<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('secret'),
            'date_of_birth' => date('Y-m-d'),
            'gender' => 'Lainnya',
            'phone' => '11111111111',
            'address' => 'Unknown',
            'photo' => null
        ]);
        $user->assignRole('Administrator');

        $user = User::firstOrCreate([
            'name' => 'Pegawai',
            'email' => 'pegawai@mail.com',
            'password' => bcrypt('secret'),
            'date_of_birth' => date('Y-m-d'),
            'gender' => 'Lainnya',
            'phone' => '2222222222',
            'address' => 'Unknown',
            'photo' => null
        ]);
        $user->assignRole('Pegawai');
        
        $user = User::firstOrCreate([
            'name' => 'Pemilik',
            'email' => 'pemilik@mail.com',
            'password' => bcrypt('secret'),
            'date_of_birth' => date('Y-m-d'),
            'gender' => 'Lainnya',
            'phone' => '33333333333',
            'address' => 'Unknown',
            'photo' => null
        ]);
        $user->assignRole('Pemilik');

        
        $user = User::firstOrCreate([
            'name' => 'Pengguna',
            'email' => 'pengguna@mail.com',
            'password' => bcrypt('secret'),
            'date_of_birth' => date('Y-m-d'),
            'gender' => 'Lainnya',
            'phone' => '44444444444',
            'address' => 'Unknown',
            'photo' => null
        ]);
        $user->assignRole('Pengguna');

        
    }
}
