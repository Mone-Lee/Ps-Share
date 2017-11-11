<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePPClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pp_classifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_classification_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('pp_classifications',function($table){
            $table->foreign('permission_classification_id')->references('id')->on('permission_classifications');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pp_classifications');
    }
}
