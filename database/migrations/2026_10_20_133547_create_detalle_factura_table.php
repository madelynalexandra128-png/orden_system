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
        Schema::create('detalleFactura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idFactura');
            $table->foreign('idFactura')->references('id')->on('factura');
            $table->unsignedBigInteger('idProducto');
            $table->foreign('idProducto')->references('id')->on('producto');
            $table->integer('cantidad');
            $table->decimal('precioUnitario',10,2);
            $table->decimal('total',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleFactura');
    }
};
