<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fee_category_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->date('due_date')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('term')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['course_id', 'fee_category_id', 'academic_year', 'term'], 'course_fee_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_fees');
    }
};
