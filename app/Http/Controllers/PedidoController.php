<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidoStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(): View {
        $pedidos = Pedido::get();

        return view('pedidos.index', [
            'pedidos' => $pedidos
        ]);
    }

    public function create(): View {
        $clientes = Cliente::get();
        $pedidos_status = PedidoStatus::get();
        $ativo_options = [
            '1' => 'Sim',
            '2' => 'Não'
        ];

        return view('pedidos.create', [
            'clientes' => $clientes,
            'pedidos_status' => $pedidos_status,
            'ativo_options' => $ativo_options
        ]);
    }

    public function store(Request $request): RedirectResponse {
        $dados = $request->except('_token');
        $dados['data'] = date('Y-m-d H:i:s');
        
        Pedido::create($dados);

        return redirect('/pedidos');
    }

    public function edit(int $id): View {
        $pedido = Pedido::find($id);
        $clientes = Cliente::get();
        $pedidos_status = PedidoStatus::get();
        $ativo_options = [
            '1' => 'Sim',
            '2' => 'Não'
        ];

        return view('pedidos.edit', [
            'pedido' => $pedido,
            'clientes' => $clientes,
            'pedidos_status' => $pedidos_status,
            'ativo_options' => $ativo_options
        ]);
    }

    public function update(int $id, Request $request): RedirectResponse {
        $pedido = Pedido::findOrFail($id);

        $pedido->update([
            'produto' => $request->produto,
            'valor' => $request->valor,
            'ativo' => $request->ativo,
            'cliente_id' => $request->cliente_id,
            'pedido_status_id' => $request->pedido_status_id
        ]);

        return redirect('/pedidos');
    }

    public function destroy(int $id): RedirectResponse {
        $pedido = Pedido::findOrFail($id);

        $pedido->delete();

        return redirect('/pedidos');
    }
}
