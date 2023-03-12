<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(): View {
        $clientes = Cliente::get();

        return view('clientes.index', [
            'clientes' => $clientes
        ]);
    }

    public function create(): View {
        $ativo_options = [
            '1' => 'Sim',
            '2' => 'Não'
        ];

        return view('clientes.create', [
            'ativo_options' => $ativo_options
        ]);
    }

    public function store(Request $request, ClienteRequest $cliente_request): RedirectResponse {
        $dados = $request->except('_token');

        Cliente::create($dados);

        return redirect('/clientes');
    }

    public function edit(int $id): View {
        $cliente = Cliente::findOrFail($id);
        $ativo_options = [
            '1' => 'Sim',
            '2' => 'Não'
        ];

        return view('clientes.edit', [
            'cliente' => $cliente,
            'ativo_options' => $ativo_options
        ]);
    }

    public function update(int $id, Request $request): RedirectResponse {
        $cliente = Cliente::findOrFail($id);

        $cliente->update([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'data_nasc' => $request->data_nasc,
            'telefone' => $request->telefone,
            'ativo' => $request->ativo
        ]);

        return redirect('/clientes');
    }

    public function destroy(int $id): RedirectResponse {
        $cliente = Cliente::findOrFail($id);

        $cliente->delete();

        return redirect('/clientes');

    }
}
