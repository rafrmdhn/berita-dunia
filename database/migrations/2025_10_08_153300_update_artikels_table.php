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
        Schema::table('artikels', function (Blueprint $table) {
            $table->string('slug')->after('judul');
            $table->unsignedBigInteger('views')->default(0)->after('dislike_count');
            $table->boolean('is_featured')->default(false)->after('kategori_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            $table->dropColumn(['views', 'is_featured']);
        });
    }
};
