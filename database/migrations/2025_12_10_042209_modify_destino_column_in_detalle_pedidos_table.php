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
        // First, set any non-numeric destino values to null
        \DB::statement("UPDATE detalle_pedidos SET destino = NULL WHERE destino IS NOT NULL AND destino NOT REGEXP '^[0-9]+$'");

        Schema::table('detalle_pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('destino')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_pedidos', function (Blueprint $table) {
            $table->string('destino', 255)->nullable()->change();
        });
    }
};
