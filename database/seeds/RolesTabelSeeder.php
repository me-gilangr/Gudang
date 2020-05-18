<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'Administrator', 'guard_name' => 'web' ]);
        Role::firstOrCreate(['name' => 'Pegawai', 'guard_name' => 'web' ]);
        Role::firstOrCreate(['name' => 'Pemilik', 'guard_name' => 'web' ]);
        Role::firstOrCreate(['name' => 'Pengguna', 'guard_name' => 'web' ]);
    }
}
