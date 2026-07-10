<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Extends the attendance status enum to include 'excused'. Uses raw SQL so
     * it works on MySQL without requiring doctrine/dbal for enum changes.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('present','absent','late','excused') NOT NULL DEFAULT 'present'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Collapse any 'excused' rows back to a valid legacy value before shrinking the enum.
        DB::statement("UPDATE attendances SET status = 'absent' WHERE status = 'excused'");
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('present','absent','late') NOT NULL DEFAULT 'present'");
    }
};
