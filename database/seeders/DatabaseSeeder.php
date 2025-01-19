<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Tag::factory()->create([
            'name' => 'Tag 1',
        ]);

        Tag::factory()->create([
            'name' => 'Tag 2',
        ]);

        Category::factory()->create([
            'name' => 'Category 1',
        ]);

        Category::factory()->create([
            'name' => 'Category 2',
        ]);
    }
}
