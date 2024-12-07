<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwitterColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter_token')->nullable(); // アクセストークン
            $table->string('twitter_token_secret')->nullable(); // アクセストークンシークレット
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['twitter_token', 'twitter_token_secret']);
        });
    }
}
