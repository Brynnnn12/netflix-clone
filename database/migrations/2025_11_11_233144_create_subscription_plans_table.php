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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basic, Premium, VIP
            $table->decimal('price', 10, 2);
            $table->integer('duration_days');
            $table->text('description')->nullable();
            $table->integer('max_users')->default(1); // max profiles
            $table->string('quality')->default('HD'); // SD, HD, 4K

            //indexes
            $table->index('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plan');
    }
};
