<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['produto', 'valor', 'data', 'ativo', 'cliente_id', 'pedido_status_id'];


    /**
     * Define a relação com Cliente
     *
     * @return void
     */
    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }
    
    /**
     * Relação com PedidoStatus
     *
     * @return void
     */
    public function pedido_status() {
        return $this->belongsTo(PedidoStatus::class);
    }

    /**
     * Relação com PedidosImagens
     *
     * @return void
     */
    public function pedidos_imagens() {
        return $this->hasMany(PedidosImagens::class);
    }
}
