@extends('app')


@section('titulo', 'Cadastrar Pedido')

@section('conteudo')
    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="produto" class="form-label">Produto</label>
            <input type="text" class="form-control" id="produto" name="produto" placeholder="Digite o produto" required>
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" step="0.01" class="form-control" id="valor" name="valor" placeholder="0,00" required maxlength="11" minlength="11">
        </div>
        <div class="mb-3">
            <label for="ativo" class="form-label">Ativo</label>
            <select class="form-control" name="ativo" id="ativo" required>
                <option value="1">Sim</option>
                <option value="2">Não</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select class="form-control" name="cliente_id" id="cliente_id">
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="pedido_status_id" class="form-label">Status do Pedido</label>
            <select class="form-control" name="pedido_status_id" id="pedido_status_id">
                @foreach ($pedidos_status as $status)
                <option value="{{ $status->id }}">{{ $status->descricao }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success" type="submit">Enviar</button>
    </form>
@endsection