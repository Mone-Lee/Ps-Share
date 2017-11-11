<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('share_id')->unsigned();
            $table->integer('collection_classification_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('collections',function($table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('share_id')->references('id')->on('shares');
            $table->foreign('collection_classification_id')->references('id')->on('collection_classifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
