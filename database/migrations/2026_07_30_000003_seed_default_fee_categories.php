<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $categories = [
            ['name' => 'Tuition', 'description' => 'Course tuition fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hostel', 'description' => 'Accommodation and boarding fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Food', 'description' => 'Meal plan and catering fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Registration', 'description' => 'Annual registration and administrative fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Library', 'description' => 'Library and resource access fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ICT', 'description' => 'Information and communication technology fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sports', 'description' => 'Sports and recreation fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Examination', 'description' => 'Examination and assessment fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laboratory', 'description' => 'Science lab and practical fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Transport', 'description' => 'School transport and bus fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Uniform', 'description' => 'Uniform and dress code fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Graduation', 'description' => 'Graduation and ceremony fees', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($categories as $category) {
            DB::table('fee_categories')->upsert(
                $category,
                ['name'],
                ['description', 'is_active', 'updated_at']
            );
        }
    }

    public function down(): void
    {
        DB::table('fee_categories')->whereIn('name', [
            'Tuition', 'Hostel', 'Food', 'Registration', 'Library',
            'ICT', 'Sports', 'Examination', 'Laboratory', 'Transport',
            'Uniform', 'Graduation',
        ])->delete();
    }
};
