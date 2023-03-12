<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cpf', 'data_nasc', 'telefone', 'ativo'];

    /**
     * Define a relação com Pedido
     *
     * @return void
     */
    public function pedidos() {
        return $this->hasMany(Pedido::class);
    }
}
