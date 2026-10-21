<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        User::updateOrCreate(
            ['email' => 'admin@php-pb.net'],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => UserRole::Admin,
                'cargo' => 'Organizador PHP-PB',
                'bio' => 'Mantenedor do site e organizador da comunidade PHP-PB.',
                'stack' => ['PHP', 'Laravel', 'Livewire'],
            ]
        );

        User::updateOrCreate(
            ['email' => 'usuario@php-pb.net'],
            [
                'name' => 'Usuário Teste',
                'slug' => 'usuario-teste',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => UserRole::Member,
                'cargo' => 'Desenvolvedor Back-End',
                'bio' => 'Membro da comunidade PHP-PB, apaixonado por PHP e Laravel.',
                'github_url' => 'https://github.com',
                'linkedin_url' => 'https://linkedin.com',
                'stack' => ['PHP', 'Laravel', 'MySQL'],
            ]
        );
    }
}
