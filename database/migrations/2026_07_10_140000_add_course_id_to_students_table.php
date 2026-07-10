<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds a nullable course_id FK to students and backfills it from the
     * existing free-text `course` column so no data is orphaned: a course row
     * is created for each distinct existing course name, then students are
     * linked. The `course` string column is kept (denormalised display value).
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('course_id')
                  ->nullable()
                  ->after('course')
                  ->constrained()
                  ->nullOnDelete();
        });

        $names = DB::table('students')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->pluck('course');

        foreach ($names as $index => $name) {
            $course = DB::table('courses')->where('name', $name)->first();

            if ($course) {
                $courseId = $course->id;
            } else {
                $base = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));
                $code = ($base ?: 'CRS') . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT);

                // Guard against a rare generated-code collision.
                while (DB::table('courses')->where('code', $code)->exists()) {
                    $code .= 'X';
                }

                $courseId = DB::table('courses')->insertGetId([
                    'code'       => $code,
                    'name'       => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('students')->where('course', $name)->update(['course_id' => $courseId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
        });
    }
};
