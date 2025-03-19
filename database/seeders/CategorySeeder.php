<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('categories')->truncate();

        $categories = [
            'Action',
            'Adventure',
            'Animation',
            'Comedy',
            'Crime',
            'Documentary',
            'Drama',
            'Fantasy',
            'Horror',
            'Musical',
            'Mystery',
            'Romance',
            'Science Fiction',
            'Thriller',
            'Western',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'title' => $category,
                'slug' => str_replace(' ', '-', strtolower($category)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
