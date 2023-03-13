<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidosImagens;
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

    public function store(Request $request, PedidoRequest $pedido_request) {
        $dados = $request->except('_token');
        $dados['data'] = date('Y-m-d H:i:s');

        $pedido = Pedido::create($dados);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $request_imagem = $request->imagem;
            $nome_original = pathinfo($request_imagem->getClientOriginalName(), PATHINFO_FILENAME);
            $extensao = pathinfo($request_imagem->getClientOriginalName(), PATHINFO_EXTENSION);
            $novo_nome = md5($nome_original . strtotime('now')) . '.' . $extensao;
            $imagem_path = 'img/pedidos/imagem';
            $capa_path = 'img/pedidos/capa';
            $request_imagem->move($imagem_path, $novo_nome);

            $pedidos_imagens = new PedidosImagens([
                'pedido_id' => $pedido->id,
                'imagem' => "$imagem_path/$novo_nome",
                'capa' => "$capa_path/$novo_nome"
            ]);
            $pedidos_imagens->save();
        }

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

    public function update(int $id, Request $request) {
        $pedido = Pedido::findOrFail($id);

        $pedido->update([
            'produto' => $request->produto,
            'valor' => $request->valor,
            'ativo' => $request->ativo,
            'cliente_id' => $request->cliente_id,
            'pedido_status_id' => $request->pedido_status_id
        ]);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $request_imagem = $request->imagem;
            $nome_original = pathinfo($request_imagem->getClientOriginalName(), PATHINFO_FILENAME);
            $extensao = pathinfo($request_imagem->getClientOriginalName(), PATHINFO_EXTENSION);
            $novo_nome = md5($nome_original . strtotime('now')) . '.' . $extensao;
            $imagem_path = 'img/pedidos/imagem';
            $capa_path = 'img/pedidos/capa';
            $request_imagem->move($imagem_path, $novo_nome);
            
            if (count($pedido->pedidos_imagens) > 0) {
                unlink($pedido->pedidos_imagens[0]->imagem);
                // unlink($pedido->pedidos_imagens[0]->capa);
                $pedido_imagem = PedidosImagens::findOrFail($pedido->pedidos_imagens[0]->id);
                $pedido_imagem->update([
                    'imagem' => "$imagem_path/$novo_nome",
                    'capa' => "$capa_path/$novo_nome"
                ]);
            } else {
                $pedidos_imagens = new PedidosImagens([
                    'pedido_id' => $pedido->id,
                    'imagem' => "$imagem_path/$novo_nome",
                    'capa' => "$capa_path/$novo_nome"
                ]);
                $pedidos_imagens->save();
            }
        }

        return redirect('/pedidos');
    }

    public function destroy(int $id): RedirectResponse {
        $pedido = Pedido::findOrFail($id);

        if (count($pedido->pedidos_imagens) > 0) {
            unlink($pedido->pedidos_imagens[0]->imagem);
            // unlink($pedido->pedidos_imagens[0]->capa);
            $pedido_imagem = PedidosImagens::findOrFail($pedido->pedidos_imagens[0]->id);
            $pedido_imagem->delete();
        } 

        $pedido->delete();

        return redirect('/pedidos');
    }

    public function export_csv() {
        $arquivo = 'pedidos.csv';
        $pedidos = Pedido::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$arquivo",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $colunas = array('id', 'Produto', 'valor', 'Data', 'Ativo', 'Cliente', 'Status');

        $callback = function() use($pedidos, $colunas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $colunas);

            foreach ($pedidos as $pedido) {
                $row['id']  = $pedido->id;
                $row['Produto']    = $pedido->produto;
                $row['Valor']    = $pedido->valor;
                $row['Data']    = $pedido->data;
                $row['Ativo']  = $pedido->ativo;
                $row['Cliente']  = $pedido->cliente->nome;
                $row['Status']  = $pedido->pedido_status->descricao;

                fputcsv($file, array($row['id'], $row['Produto'], $row['Valor'], $row['Data'], $row['Ativo'], $row['Cliente'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
