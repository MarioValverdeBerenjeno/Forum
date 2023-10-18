<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');     // Creamos la columna que hará de clave foránea
            $table->foreign('user_id')->references('id')->on('users');    // Definición de la clave foránea
            $table->unsignedBigInteger('forum_id');     // Creamos la columna que hará de clave foránea
            $table->foreign('forum_id')->references('id')->on('forums');    // Definición de la clave foránea
            $table->string('title');     		// Título del Post
            $table->text('description');    	// Descripción del Post
            $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
