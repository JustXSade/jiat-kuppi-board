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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('author_name')->default('JIAT Student');
        $table->string('title');
        $table->text('content');
        $table->string('category')->default('Kuppi');
        $table->string('tags')->nullable();
        $table->string('status')->default('Open');
        $table->text('ai_summary')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
