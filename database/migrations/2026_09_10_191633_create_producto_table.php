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
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->decimal('precio');
            $table->decimal('precioCompra');
            $table->integer('stock');
            $table->string('estado');
            $table->integer('puntos');
            $table->string('imagen');


            $table->unsignedBigInteger('idCategoria');
            $table->foreign('idCategoria')->references('id')->on('categoria');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
