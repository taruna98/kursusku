<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call All Role
        $this->call(PermissionSeeder::class);

        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@kursusku.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_verified' => true,
        ]);
        $admin->assignRole('admin');

        // Mentor (verified)
        $mentor = User::create([
            'name' => 'Mentor Demo',
            'email' => 'mentor@kursusku.test',
            'password' => bcrypt('password'),
            'role' => 'mentor',
            'is_verified' => true,
        ]);
        $mentor->assignRole('mentor');

        // Siswa
        $siswa = User::create([
            'name' => 'Siswa Demo',
            'email' => 'siswa@kursusku.test',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);
        $siswa->assignRole('siswa');

        // Kategori
        $categories = ['Desain Grafis', 'Pemrograman', 'Fotografi', 'Marketing', 'Bahasa Asing'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }

        // $this->call(PermissionSeeder::class);
    }
}
