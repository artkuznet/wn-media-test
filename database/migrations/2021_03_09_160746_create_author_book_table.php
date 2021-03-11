<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('author_book', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('book_id');
            $table->foreign('author_id')
                ->references('id')
                ->on('author')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('book_id')
                ->references('id')
                ->on('book')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->primary([
                'author_id',
                'book_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('author_book');
    }
}
