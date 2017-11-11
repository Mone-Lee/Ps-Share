<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->text('path'); // 图片路径
            $table->string('content',50)->nullable(); // 图片描述
            $table->integer('order')->default(0); // 顺序
            $table->integer('share_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('share_pictures',function($table){
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
        Schema::dropIfExists('share_pictures');
    }
}
