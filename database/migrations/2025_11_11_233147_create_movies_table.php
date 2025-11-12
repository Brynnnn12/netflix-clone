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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('thumbnail')->nullable(); // path to image
            $table->string('video_url'); // S3 URL or local path
            $table->integer('duration')->nullable(); // in minutes
            $table->decimal('rating', 3, 1)->nullable();
            $table->boolean('is_premium')->default(true);
            $table->boolean('is_active')->default(true);

            //indexes
            $table->index('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie');
    }
};
