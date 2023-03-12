@extends('app')


@section('titulo', 'Editar Pedido')

@section('conteudo')
    <form action="{{ route('pedidos.update', $pedido) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3">
            <label for="imagem" class="form-label">Imagem</label><br>
            @if (count($pedido->pedidos_imagens) > 0)
            <a href="/{{ $pedido->pedidos_imagens[0]->imagem }}" target="_blank">Uploaded Imagem</a><br>
            @endif
            <input type="file" class="form-control-file" id="imagem" name="imagem">
        </div>
        <div class="mb-3">
            <label for="produto" class="form-label">Produto</label>
            <input type="text" value="{{ $pedido->produto }}" class="form-control" id="produto" name="produto" placeholder="Digite o produto" required>
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" value="{{ $pedido->valor }}" step="0.01" class="form-control" id="valor" name="valor" placeholder="0,00" required maxlength="11" minlength="11">
        </div>
        <div class="mb-3">
            <label for="ativo" class="form-label">Ativo</label>
            <select class="form-control" name="ativo" id="ativo" required>
                @foreach ($ativo_options as $key => $option)
                <option value="{{ $key }}"
                @if ($key == $pedido->ativo)
                    selected
                @endif
                >{{ $option }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select class="form-control" name="cliente_id" id="cliente_id">
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}"
                @if ($cliente->id == $pedido->cliente_id)
                    selected
                @endif
                >{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="pedido_status_id" class="form-label">Status do Pedido</label>
            <select class="form-control" name="pedido_status_id" id="pedido_status_id">
                @foreach ($pedidos_status as $status)
                <option value="{{ $status->id }}"
                @if ($status->id == $pedido->pedido_status_id)
                    selected
                @endif
                >{{ $status->descricao }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success" type="submit">Enviar</button>
    </form>
@endsection