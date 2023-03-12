<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoStatus extends Model
{
    use HasFactory;

    protected $fillable = ['descricao'];

    /**
     * Personaliza o nome da tabela do model PedidoStatus, pois por padrão o Eloquent busca a tabela pedido_statuses
     *
     * @var string
     */
    protected $table = 'pedido_status';

    /**
     * Define a relação com Pedido
     *
     * @return void
     */
    public function pedidos() {
        return $this->hasMany(Pedido::class);
    }
}
