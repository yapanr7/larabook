<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Member',
            'email'     => 'member@gmail.com',
            'password'  => bcrypt('password'),
        ]);

        User::create([
            'name'      => 'Rafael Nuansa',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('password'),
            'is_admin' => true,
        ]);
    }
}
