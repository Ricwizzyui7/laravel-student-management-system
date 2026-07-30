<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $departments = [
            ['name' => 'Computing & IT', 'description' => 'Computer science, IT, and software engineering programs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engineering', 'description' => 'Electrical, mechanical, and civil engineering programs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business', 'description' => 'Accounting, finance, marketing, and management programs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Health Sciences', 'description' => 'Medicine, nursing, and public health programs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Education', 'description' => 'Teaching and educational leadership programs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Law', 'description' => 'Legal studies and jurisprudence programs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Arts & Humanities', 'description' => 'Literature, history, and liberal arts programs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Science', 'description' => 'Biology, chemistry, physics, and mathematics programs', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($departments as $dept) {
            DB::table('departments')->upsert($dept, ['name'], ['description', 'updated_at']);
        }
    }

    public function down(): void
    {
        DB::table('departments')->whereIn('name', [
            'Computing & IT', 'Engineering', 'Business', 'Health Sciences',
            'Education', 'Law', 'Arts & Humanities', 'Science',
        ])->delete();
    }
};
