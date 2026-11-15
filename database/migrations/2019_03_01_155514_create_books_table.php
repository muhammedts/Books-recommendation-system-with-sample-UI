<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            // The id is the goodbooks-10k book_id when imported with books:import.
            $table->id();
            $table->string('title', 500);
            $table->string('authors', 1000);
            // ISBNs keep leading zeros and a trailing "X", so they are strings.
            $table->string('isbn', 20)->nullable();
            $table->smallInteger('original_publication_year')->nullable();
            $table->string('language_code', 16)->nullable();
            // Either a remote URL or a path on the "public" disk.
            $table->string('image_url')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->unsignedInteger('ratings_count')->default(0);
            $table->timestamps();

            $table->index('title');
            $table->index('ratings_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
