<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->Integer('recommendation1');
            $table->Integer('recommendation2');
            $table->Integer('recommendation3');
            $table->Integer('recommendation4');
            $table->Integer('recommendation5');
            $table->Integer('recommendation6');
            $table->Integer('recommendation7');
            $table->Integer('recommendation8');
            $table->Integer('recommendation9');
            $table->Integer('recommendation10');
            $table->bigInteger('userId')->unsigned();
            $table->timestamps();
        });

        Schema::table('recommendations', function (Blueprint $table) {
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recommendations');
    }
}
