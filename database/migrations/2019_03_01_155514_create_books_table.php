<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('isbn');
            $table->String('authors');
            $table->Integer('original_publication_year');
            $table->String('title');
            $table->String('language_code');
            $table->decimal('average_rating');
            $table->Integer('work_ratings_count');
            $table->Integer('work_text_reviews_count');
            $table->Integer('ratings_1');
            $table->Integer('ratings_2');
            $table->Integer('ratings_3');
            $table->Integer('ratings_4');
            $table->Integer('ratings_5');
            $table->String('image_url');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
