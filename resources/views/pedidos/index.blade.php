@extends('app')


@section('titulo', 'Lista de Pedidos')


@section('conteudo')
        <a class="btn btn-dark" href="{{ route('pedidos.create') }}">Novo Pedido</a><br><br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Data</th>
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
                    <td scope="row">R$ {{ number_format($pedido->valor, 2, ',', '.') }}</td>
                    <td scope="row">{{ date('d/m/Y', strtotime($pedido->data)) }}</td>
                    <td scope="row">
                        @if ($pedido->ativo == '1')
                        Sim
                        @elseif ($pedido->ativo == 2)
                        Não
                        @endif
                    </td>
                    <td scope="row">{{ $pedido->cliente->nome }}</td>
                    <td scope="row">{{ $pedido->pedido_status->descricao }}</td>
                    <td scope="row">
                        <a class="btn btn-dark" href="{{ route('pedidos.edit', $pedido) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" style="display: inline">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Tem certeza que deseja apagar? Esta operação é irreversível')"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
@endsection