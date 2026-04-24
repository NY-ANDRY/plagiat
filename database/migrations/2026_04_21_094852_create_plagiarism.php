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
        Schema::create('algos', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('about')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('algo_props', function (Blueprint $table) {
            $table->id();

            $table->foreignId('algo_id')->constrained('algos')->cascadeOnDelete();
            $table->string('name');
            $table->string('about');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('raw_projects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->longText('content');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('fingerprints', function (Blueprint $table) {
            $table->id();

            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->foreignId('raw_project_id')->constrained('raw_projects')->cascadeOnDelete();
            $table->string('hash_value', 32)->index();
            $table->unsignedInteger('position');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plagiarisms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('algo_id')->constrained('algos')->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->decimal('rate', 5, 2)->default(0);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plagiarism_algo_props', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plagiarism_id')->constrained('plagiarisms')->cascadeOnDelete();
            $table->foreignId('algo_prop_id')->constrained('algo_props')->cascadeOnDelete();
            $table->text('value')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plagiarism_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plagiarism_id')->constrained('plagiarisms')->cascadeOnDelete();
            $table->foreignId('submission_1_id')->constrained('submissions')->cascadeOnDelete();
            $table->foreignId('submission_2_id')->constrained('submissions')->cascadeOnDelete();
            $table->decimal('rate', 5, 2)->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plagiarism_results');
        Schema::dropIfExists('plagiarism_algo_props');
        Schema::dropIfExists('plagiarisms');
        Schema::dropIfExists('fingerprints');
        Schema::dropIfExists('raw_projects');
        Schema::dropIfExists('algo_props');
        Schema::dropIfExists('algos');
    }
};
