<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->nullable()->unsigned(); // 父id
            $table->string('content',100); // 评论内容
            $table->integer('status')->default(0); // 状态，1：已读，0：未读，默认0
            $table->integer('user_id')->unsigned(); //回复者id
            $table->integer('usered_id')->unsigned(); //被回复者id
            $table->integer('share_id')->unsigned();
            $table->integer('comment_id')->unsigned(); // 此评论回复属于那条评论
            $table->timestamps();
        });
        Schema::table('comments',function($table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('share_id')->references('id')->on('shares');
            $table->foreign('pid')->references('id')->on('comment_replies');
            $table->foreign('comment_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
