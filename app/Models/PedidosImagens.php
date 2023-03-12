<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosImagens extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id', 'imagem', 'capa'];

    /**
     * Define o nome da tabela manualmente
     *
     * @var string
     */
    protected $table = 'pedidos_imagens';

    /**
     * Define a relação com Pedido
     *
     * @return void
     */
    public function pedidos() {
        return $this->belongsTo(Pedido::class);
    }
}
