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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->decimal('cantidad', 10, 2);
            $table->string('destino', 255)->nullable();
            $table->tinyInteger('recibido')->default(0);
            $table->decimal('cantidad_recibida', 10, 2)->default(0);
            $table->date('fecha_recibido')->nullable();
            $table->mediumText('cotizacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
