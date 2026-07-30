<?php

namespace Database\Seeders;

use App\Models\FeeCategory;
use Illuminate\Database\Seeder;

class FeeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tuition', 'description' => 'Course tuition fees'],
            ['name' => 'Hostel', 'description' => 'Accommodation and boarding fees'],
            ['name' => 'Food', 'description' => 'Meal plan and catering fees'],
            ['name' => 'Registration', 'description' => 'Annual registration and administrative fees'],
            ['name' => 'Library', 'description' => 'Library and resource access fees'],
            ['name' => 'ICT', 'description' => 'Information and communication technology fees'],
            ['name' => 'Sports', 'description' => 'Sports and recreation fees'],
            ['name' => 'Examination', 'description' => 'Examination and assessment fees'],
            ['name' => 'Laboratory', 'description' => 'Science lab and practical fees'],
            ['name' => 'Transport', 'description' => 'School transport and bus fees'],
            ['name' => 'Uniform', 'description' => 'Uniform and dress code fees'],
            ['name' => 'Graduation', 'description' => 'Graduation and ceremony fees'],
        ];

        foreach ($categories as $category) {
            FeeCategory::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description'], 'is_active' => true]
            );
        }
    }
}
