<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('follower_id')->unsigned(); //关注者id
            $table->integer('followed_id')->unsigned(); //被关注者id
            $table->integer('follow_classification_id')->unsigned(); //分类id
            $table->timestamps();
        });
        Schema::table('follows',function($table){
            $table->foreign('follower_id')->references('id')->on('users');
            $table->foreign('followed_id')->references('id')->on('users');
            $table->foreign('follow_classification_id')->references('id')->on('follow_classifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
