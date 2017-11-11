<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id'); // 举报者id
            $table->integer('report_classification_id'); // 举报分类id
            $table->integer('share_id'); // 被举报分享id
            $table->integer('status')->default(0); // 举报状态，0：默认，1：屏蔽
            $table->string('content')->nullable; // 举报内容
            $table->timestamps();
        });
        Schema::table('share_reports', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('report_classification_id')->references('id')->on('report_classifications');
            $table->foreign('share_id')->references('id')->on('shares');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_reports');
    }
}
