<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nom' => 'administrateur', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'chef_projet', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'collaborateur', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
