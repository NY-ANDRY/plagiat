<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('algorithmes', function (Blueprint $table) {
        //     $table->id();

        //     $table->string('name');
        //     $table->string('about');

        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // Schema::create('fingerprints', function (Blueprint $table) {
        //     $table->id();

        //     // $table->js

        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // Schema::create('plagiarism', function (Blueprint $table) {
        //     $table->id();



        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // Schema::create('plagiarism_results', function (Blueprint $table) {
        //     $table->id();

        //     $table->foreignId('algo_id')->constrained('algo')->cascadeOnDelete();
        //     $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
        //     $table->foreignId('rate');

        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // Schema::create('plagiarism_result_details', function (Blueprint $table) {
        //     $table->id();

        //     $table->foreignId('plagiarism_results_id')->constrained('plagiarism_results')->cascadeOnDelete();
        //     $table->foreignId('submission_1_id')->constrained('submission');
        //     $table->foreignId('submission_2_id')->constrained('submission');
        //     $table->foreignId('rate');

        //     $table->softDeletes();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('plagiarism');
    }
};
