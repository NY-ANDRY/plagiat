<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('file_extensions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('extension')->unique();
            $table->string('url_icon')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('url_icon')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('file_restrictions', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->foreignId('file_type_id')->constrained('file_types');
            $table->foreignId('file_extension_id')->nullable()->constrained('file_extensions')->nullOnDelete();
            $table->string('url_icon')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('about');
            $table->date('close_date');
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('exam_file_restriction', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('restriction_id')->constrained('file_restrictions')->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('exam_file_extension', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('file_extension_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_file_extension');
        Schema::dropIfExists('exam_file_restriction');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('file_restrictions');
        Schema::dropIfExists('file_types');
        Schema::dropIfExists('file_extensions');
    }
};
