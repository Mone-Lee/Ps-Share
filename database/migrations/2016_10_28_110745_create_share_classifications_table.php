<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_classifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10); // 分类名
            $table->integer('pid')->unsigned()->nullable(); // 父id
            $table->timestamps();
        });
        Schema::table('share_classifications',function($table){
            $table->foreign('pid')->references('id')->on('share_classifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_classifications');
    }
}
