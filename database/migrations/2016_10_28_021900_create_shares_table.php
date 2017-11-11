<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content', 300)->nullable(); // 内容
            $table->string('abstract', 50)->nullable(); // 摘要
            $table->integer('status')->default(0); // 表示这篇分享的状态，0：仅保存未发布，1：已发布，2：屏蔽，3管理员禁止，默认0
            $table->integer('user_id')->unsigned();
            $table->integer('share_classification_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('shares',function($table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('share_classification_id')->references('id')->on('share_classifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shares');
    }
}
