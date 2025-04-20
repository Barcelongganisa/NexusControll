<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'User'],
            // Add more roles as needed
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}