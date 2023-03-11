@extends('app')


@section('titulo', 'Lista de Clientes')


@section('conteudo')
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Data de nascimento</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Ativo</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <th scope="row">{{ $cliente->id }}</th>
                    <td scope="row">{{ $cliente->nome }}</td>
                    <td scope="row">{{ $cliente->cpf }}</td>
                    <td scope="row">{{ date('d/m/Y', strtotime($cliente->data_nasc)) }}</td>
                    <td scope="row">{{ $cliente->telefone }}</td>
                    <td scope="row">{{ $cliente->ativo }}</td>
                    <td scope="row">
                        <a class="btn btn-primary" href="{{ route('clientes.edit', $cliente) }}">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display: inline">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Tem certeza que deseja apagar? Esta operação é irreversível')">Apagar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-success" href="{{ route('clientes.create') }}">Novo Cliente</a>
@endsection