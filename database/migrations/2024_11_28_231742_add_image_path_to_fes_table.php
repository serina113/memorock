<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagePathToFesTable extends Migration
{
    public function up()
    {
        Schema::table('fes', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('body'); // 画像パスを保存するカラムを追加
        });
    }

    public function down()
    {
        Schema::table('fes', function (Blueprint $table) {
            $table->dropColumn('image_path'); // ロールバック時にカラムを削除
        });
    }
}
