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
        Schema::create('fes', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('title');
            $table->string('fes_name'); // Fes 名称
            $table->text('body')->nullable(); // 全体の感想
            $table->string('hashtag');//ハッシュタグ
            $table->date('date');//開催日時
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ユーザーテーブルとの外部キー
            $table->timestamps(); // created_at と updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fes');
    }
};
