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
        Schema::table('factura', function (Blueprint $table) {

            $table->unsignedBigInteger('idCliente')
                ->nullable()
                ->change();

            $table->string('metodoPago')
                ->nullable()
                ->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factura', function (Blueprint $table) {

            $table->unsignedBigInteger('idCliente')
                ->nullable(false)
                ->change();

            $table->string('metodoPago')
                ->nullable(false)
                ->change();

        });
    }
};
