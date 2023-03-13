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
    /**
     * Lista os pedidos
     *
     * @return View
     */
    public function index(): View {
        $pedidos = Pedido::get();

        return view('pedidos.index', [
            'pedidos' => $pedidos
        ]);
    }

    /**
     * Renderiza o formulário de cadastro de pedidos
     *
     * @return View
     */
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

    /**
     * Grava os dados do formulário de Pedidos no banco de dados
     *
     * @param Request $request
     * @param PedidoRequest $pedido_request
     * @return void
     */
    public function store(Request $request, PedidoRequest $pedido_request): RedirectResponse {
        $dados = $request->except('_token');
        $dados['data'] = date('Y-m-d H:i:s');
        
        $pedido = Pedido::create($dados);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $caminho = 'img/pedidos';
            
            list($nome, $extensao) = $this->obter_novo_nome($request);
            
            $this->salvar_imagem($request, $nome, $extensao, $caminho);
            $this->criar_capa($nome, $extensao, $caminho);

            $caminho_imagem_str = "$caminho/$nome.$extensao";
            $caminho_capa_str = "$caminho/$nome-capa.$extensao";

            $pedidos_imagens = new PedidosImagens([
                'pedido_id' => $pedido->id,
                'imagem' => $caminho_imagem_str,
                'capa' => $caminho_capa_str
            ]);
            $pedidos_imagens->save();
        }

        return redirect('/pedidos');
    }

    /**
     * Cria um novo nome único para a imagem
     *
     * @param Request $request
     * @return Array
     */
    private function obter_novo_nome(Request $request): Array {
        $request_imagem = $request->imagem;
        $nome_original = pathinfo($request_imagem->getClientOriginalName(), PATHINFO_FILENAME);
        $extensao = pathinfo($request_imagem->getClientOriginalName(), PATHINFO_EXTENSION);
        $novo_nome = md5($nome_original . strtotime('now'));
        return [$novo_nome, $extensao];
    }

    /**
     * Salva a imagem na pasta /public/img/pedidos
     *
     * @param Request $request
     * @param String $nome
     * @param String $extensao
     * @param String $path
     * @return void
     */
    private function salvar_imagem(Request $request, String $nome, String $extensao, String $path): Void {
        $request_imagem = $request->imagem;
        $request_imagem->move($path, "$nome.$extensao");
    }

    /**
     * Copia a imagem, redimensiona e salva na pasta /public/img/pedidos
     *
     * @param String $nome
     * @param String $extensao
     * @param String $path
     * @return void
     */
    private function criar_capa(String $nome, String $extensao, String $path): Void {
        $arquivo = "$path/$nome.$extensao";
        
        list($largura, $altura) = getimagesize($arquivo);
        $nova_largura = 100;
        $nova_altura = 90;

        $nova_imagem = imagecreatetruecolor($nova_largura, $nova_altura);
        $fonte = imagecreatefromjpeg($arquivo);
        imagecopyresized($nova_imagem, $fonte, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura, $altura);
        $novo_arquivo = "$path/$nome-capa.$extensao";
        imagejpeg($nova_imagem, $novo_arquivo);
    }

    /**
     * Renderiza o formulário de pedidos para edição
     *
     * @param integer $id
     * @return View
     */
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

    /**
     * Salva as alterações do formulário de pedidos no banco de dados
     *
     * @param integer $id
     * @param Request $request
     * @return void
     */
    public function update(int $id, Request $request): RedirectResponse {
        $pedido = Pedido::findOrFail($id);

        $pedido->update([
            'produto' => $request->produto,
            'valor' => $request->valor,
            'ativo' => $request->ativo,
            'cliente_id' => $request->cliente_id,
            'pedido_status_id' => $request->pedido_status_id
        ]);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $caminho = 'img/pedidos';
            
            list($nome, $extensao) = $this->obter_novo_nome($request);
            
            $this->salvar_imagem($request, $nome, $extensao, $caminho);
            $this->criar_capa($nome, $extensao, $caminho);

            $caminho_imagem_str = "$caminho/$nome.$extensao";
            $caminho_capa_str = "$caminho/$nome-capa.$extensao";
            
            if (count($pedido->pedidos_imagens) > 0) {
                unlink($pedido->pedidos_imagens[0]->imagem);
                unlink($pedido->pedidos_imagens[0]->capa);
                $pedido_imagem = PedidosImagens::findOrFail($pedido->pedidos_imagens[0]->id);
                $pedido_imagem->update([
                    'imagem' => "$caminho_imagem_str",
                    'capa' => "$caminho_capa_str"
                ]);
            } else {
                $pedidos_imagens = new PedidosImagens([
                    'pedido_id' => $pedido->id,
                    'imagem' => $caminho_imagem_str,
                    'capa' => $caminho_capa_str
                ]);
                $pedidos_imagens->save();
            }
        }

        return redirect('/pedidos');
    }

    /**
     * Apaga o registro de pedidos do banco de dados e seus respectivos arquivos
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse {
        $pedido = Pedido::findOrFail($id);

        if (count($pedido->pedidos_imagens) > 0) {
            unlink($pedido->pedidos_imagens[0]->imagem);
            unlink($pedido->pedidos_imagens[0]->capa);
            $pedido_imagem = PedidosImagens::findOrFail($pedido->pedidos_imagens[0]->id);
            $pedido_imagem->delete();
        } 

        $pedido->delete();

        return redirect('/pedidos');
    }

    /**
     * Exporta os pedidos para arquivo csv.
     *
     * @return void
     */
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
