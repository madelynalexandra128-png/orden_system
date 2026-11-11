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
        Schema::create('accesoQr', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idMesa')
                ->constrained('mesa')
                ->cascadeOnDelete();

            $table->string('token')->unique();

            $table->string('estado')->default('activo');

            $table->timestamp('venceEn')->nullable();

            $table->timestamps();

            $table->index(['idMesa', 'estado']);
            $table->index('venceEn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesoQr');
    }
};
