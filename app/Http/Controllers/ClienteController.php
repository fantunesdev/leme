<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Lista os clientes cadastrados
     *
     * @return View
     */
    public function index(): View {
        $clientes = Cliente::get();

        return view('clientes.index', [
            'clientes' => $clientes
        ]);
    }

    /**
     * Renderiza o formulário para cadastro de Cliente
     *
     * @return View
     */
    public function create(): View {
        // Seta as opções para o campo ativos
        $ativo_options = [
            '1' => 'Sim',
            '2' => 'Não'
        ];

        return view('clientes.create', [
            'ativo_options' => $ativo_options
        ]);
    }

    /**
     * Salva os dados do formulário de cliente no banco de dados
     *
     * @param Request $request
     * @param ClienteRequest $cliente_request
     * @return RedirectResponse
     */
    public function store(Request $request, ClienteRequest $cliente_request): RedirectResponse {
        $dados = $request->except('_token');

        Cliente::create($dados);

        return redirect('/clientes');
    }

    /**
     * Renderiza o formulário de edição de cliente
     *
     * @param integer $id
     * @return View
     */
    public function edit(int $id): View {
        $cliente = Cliente::findOrFail($id);

        // Seta as opções para o campo ativo
        $ativo_options = [
            '1' => 'Sim',
            '2' => 'Não'
        ];

        return view('clientes.edit', [
            'cliente' => $cliente,
            'ativo_options' => $ativo_options
        ]);
    }

    /**
     * Salva as alterações do formulário de clientes no banco de dados
     *
     * @param integer $id
     * @param Request $request
     * @param ClienteRequest $cliente_request
     * @return RedirectResponse
     */
    public function update(int $id, Request $request, ClienteRequest $cliente_request): RedirectResponse {
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

    /**
     * Apaga o cliente do banco de dados
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse {
        $cliente = Cliente::findOrFail($id);

        $cliente->delete();

        return redirect('/clientes');

    }
}
