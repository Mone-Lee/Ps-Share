<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_classifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',10); // 分类名
            $table->integer('status')->default(1); // 是否公开此分类，0：否，1：是，默认1
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('follow_classifications',function($table){
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_classifications');
    }
}
