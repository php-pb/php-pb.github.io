<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            'PHP',
            'Laravel',
            'Livewire',
            'Filament',
            'Symfony',
            'Boas Práticas',
            'Testes',
            'DevOps',
            'Carreira',
            'Comunidade',
            'Eventos',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name],
            );
        }
    }
}
