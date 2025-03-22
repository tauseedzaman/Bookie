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
        Schema::create('book_marks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('url');
            $table->string('description')->nullable();
            $table->foreignId('category_id')->references('id')->on('book_marks_categories')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_favorite')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_marks');
    }
};
