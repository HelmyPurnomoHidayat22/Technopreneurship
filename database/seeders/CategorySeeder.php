<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'PPT'],
            ['name' => 'CV'],
            ['name' => 'Undangan'],
            ['name' => 'Notion'],
            ['name' => 'Canva Template'],
            ['name' => 'Social Media Kit'],
            ['name' => 'Logo Design'],
            ['name' => 'Icon Pack'],
            ['name' => 'Video Template'],
            ['name' => 'Font Pack'],
            ['name' => 'Mockup'],
            ['name' => 'Custom Design'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
