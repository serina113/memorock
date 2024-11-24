<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('body');
            $table->foreignId('fes_id')->constrained('fes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        //Schema::table('artists', function (Blueprint $table) {
            // 例: 追加したカラムを削除
            //$table->dropForeign(['fes_id']);
            //$table->dropColumn('fes_id');
        //});
    }
};
