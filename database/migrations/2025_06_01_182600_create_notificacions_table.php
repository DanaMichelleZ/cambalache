<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');        // A quién va dirigida
            $table->unsignedBigInteger('from_user_id');   // Quién la envía
            $table->unsignedBigInteger('publicacion_id'); // A qué publicación se refiere

            $table->string('mensaje');
            $table->boolean('leida')->default(false);

            $table->timestamps();

            // Claves foráneas (si querés mantener integridad referencial)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('publicacion_id')->references('id')->on('publicaciones')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
