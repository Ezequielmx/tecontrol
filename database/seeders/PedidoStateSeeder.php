<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PedidoState;

class PedidoStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PedidoState::create(['nombre' => 'PENDIENTE']);
        PedidoState::create(['nombre' => 'ENVIADO']);
        PedidoState::create(['nombre' => 'RECIBIDO']);
    }
}
