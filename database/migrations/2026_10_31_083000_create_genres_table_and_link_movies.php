<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('genre');
        });

        Schema::table('movies', function (Blueprint $table) {
            $table->foreignId('genre_id')->constrained();
            $table->string('image_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('genre_id');
            $table->dropColumn('image_url');
        });

        Schema::table('movies', function (Blueprint $table) {
            $table->string('genre');
        });

        Schema::dropIfExists('genres');
    }
};
