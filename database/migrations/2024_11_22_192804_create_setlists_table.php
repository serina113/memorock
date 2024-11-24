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
        Schema::create('setlists', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('song_name'); // 曲名
            $table->bigInteger('position');//曲順
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade'); // 外部キー
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setlists');
    }
};
