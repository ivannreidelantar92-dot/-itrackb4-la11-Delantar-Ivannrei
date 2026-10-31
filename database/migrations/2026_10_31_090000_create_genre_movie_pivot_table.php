<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('genre_movie', function (Blueprint $table) {
            $table->foreignId('genre_id')->constrained()->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->primary(['genre_id', 'movie_id']);
        });

        DB::table('movies')
            ->whereNotNull('genre_id')
            ->select(['id', 'genre_id'])
            ->orderBy('id')
            ->each(function (object $movie): void {
                DB::table('genre_movie')->insert([
                    'genre_id' => $movie->genre_id,
                    'movie_id' => $movie->id,
                ]);
            });

        Schema::table('movies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('genre_id');
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->foreignId('genre_id')->nullable()->constrained();
        });

        DB::table('genre_movie')
            ->select(['movie_id', 'genre_id'])
            ->orderBy('movie_id')
            ->each(function (object $genreMovie): void {
                DB::table('movies')
                    ->where('id', $genreMovie->movie_id)
                    ->update(['genre_id' => $genreMovie->genre_id]);
            });

        Schema::dropIfExists('genre_movie');
    }
};
