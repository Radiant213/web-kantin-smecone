<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@smecone.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create a demo pembeli
        User::create([
            'name' => 'Siswa Demo',
            'email' => 'siswa@kantin.test',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

        // Run kantin seeder (creates penjual users, kantins, kiosks, menus)
        $this->call(KantinSeeder::class);
    }
}
