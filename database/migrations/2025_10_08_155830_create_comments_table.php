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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')
                ->constrained('artikels')
                ->onDelete('cascade');
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('comments')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('avatar')->nullable();
            $table->string('website')->nullable();
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
