<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Written by the Spark ALS job (truncate + refill), read by the web app.
     * Keep the column names and types stable.
     */
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rank');
            $table->double('score');
            $table->timestamp('generated_at')->useCurrent();

            $table->primary(['user_id', 'rank']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
