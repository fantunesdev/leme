@extends('app')


@section('titulo', 'Lista de Pedidos')


@section('conteudo')
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Data de nascimento</th>
                    <th scope="col">Ativo</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                <tr>
                    <th scope="row">{{ $pedido->id }}</th>
                    <td scope="row">{{ $pedido->produto }}</td>
                    <td scope="row">{{ $pedido->valor }}</td>
                    <td scope="row">{{ date('d/m/Y', strtotime($pedido->data)) }}</td>
                    <td scope="row">{{ $pedido->ativo }}</td>
                    <td scope="row">{{ $pedido->cliente->nome }}</td>
                    <td scope="row">{{ $pedido->pedido_status->descricao }}</td>
                    <td scope="row">
                        <a class="btn btn-primary" href="{{ route('pedidos.edit', $pedido) }}">Editar</a>
                        <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" style="display: inline">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Tem certeza que deseja apagar? Esta operação é irreversível')">Apagar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-success" href="{{ route('pedidos.create') }}">Novo Cliente</a>
@endsection