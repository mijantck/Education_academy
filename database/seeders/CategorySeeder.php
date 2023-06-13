<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Tag;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Category Name',
                'short_description' => 'Category Description',
                'image' => 'category_image.jpg',
                'tag_names' => ['sdfsd', '5454', 'gfd', '22ds'],
            ],
        ];

        foreach ($data as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'short_description' => $categoryData['short_description'],
                'image' => $categoryData['image'],
            ]);

            $tagNames = $categoryData['tag_names'];
            $tags = [];

            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tags[] = $tag->id;
            }

            $category->tags()->sync($tags);
        }
    }
}
