<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['name' => 'Acrilicas', 'slug' => 'acrilicas', 'sort_order' => 1],
            ['name' => 'Gel', 'slug' => 'gel', 'sort_order' => 2],
            ['name' => 'French', 'slug' => 'french', 'sort_order' => 3],
        ];

        foreach ($defaults as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }
    }
}
