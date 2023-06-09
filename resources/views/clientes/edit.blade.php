@extends('app')


@section('titulo', 'Editar Cliente')

@section('conteudo')
    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
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
            <label for="nome" class="form-label">Nome</label>
            <input type="text" value="{{ $cliente->nome }}" class="form-control" id="nome" name="nome" placeholder="Digite o nome" required>
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" value="{{ $cliente->cpf }}" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" required>
        </div>
        <div class="mb-3">
            <label for="data_nasc" class="form-label">Data de nascimento</label>
            <input type="datetime-local" value="{{ $cliente->data_nasc }}" class="form-control" id="data_nasc" name="data_nasc" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" value="{{ $cliente->telefone }}" class="form-control" id="telefone" name="telefone" placeholder="(xx) xxxxx-xxxx">
        </div>
        <div class="mb-3">
            <label for="ativo" class="form-label">Ativo</label>
            <select class="form-control" name="ativo" id="ativo" required>
                @foreach ($ativo_options as $key => $option)
                <option value="{{ $key }}"
                @if ($key == $cliente->ativo)
                    selected
                @endif
                >{{ $option }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success" type="submit">Enviar</button>
    </form>
@endsection