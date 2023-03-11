<?php

namespace App\Http\Controllers;

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
        return view('clientes.create');
    }

    public function store(Request $request): RedirectResponse {
        $dados = $request->except('_token');

        Cliente::create($dados);

        return redirect('/clientes');
    }

    public function edit(int $id): View {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.edit', [
            'cliente' => $cliente
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
