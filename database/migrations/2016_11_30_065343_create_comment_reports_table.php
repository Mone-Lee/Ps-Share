<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id'); // 举报者id
            $table->integer('report_classification_id'); // 举报分类id
            $table->integer('comment_id'); // 被评论id
            $table->integer('status')->default(0); // 举报状态，0：默认，1：忽略
            $table->string('content')->nullable; // 举报内容
            $table->timestamps();
        });
        Schema::table('comment_reports', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('comment_id')->references('id')->on('comments');
            $table->foreign('report_classification_id')->references('id')->on('report_classifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_reports');
    }
}
