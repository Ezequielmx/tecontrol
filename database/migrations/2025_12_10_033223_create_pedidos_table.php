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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('nro');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->date('fecha');
            $table->unsignedBigInteger('pedido_state_id')->default(1);
            $table->mediumText('solicitudPedido')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->mediumText('pedido')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->mediumText('ordenCompra')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->mediumText('observaciones')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->integer('contacto')->nullable();
            $table->string('ref', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('condicion', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('plazoEntrega', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('lugarEntrega', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->mediumText('nota')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->date('fechaContacto')->nullable();
            $table->mediumText('detalleContacto')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('nroPedido', 50)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
