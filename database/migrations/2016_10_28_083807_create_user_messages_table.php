<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pic')->default('images/default.png'); // 头像图片路径
            $table->integer('sex')->default(0); // 性别，0：女性，1：男性，默认0
            $table->string('introduction', 140); // 个人介绍
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('user_messages',function($table){
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
        Schema::dropIfExists('user_messages');
    }
}
