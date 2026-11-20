<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factura', function (Blueprint $table) {

            $table->decimal('montoEfectivo', 10, 2)->default(0);
            $table->decimal('montoTarjeta', 10, 2)->default(0);
            $table->decimal('montoTransferencia', 10, 2)->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('factura', function (Blueprint $table) {

            $table->dropColumn([
                'montoEfectivo',
                'montoTarjeta',
                'montoTransferencia'
            ]);

        });
    }
};