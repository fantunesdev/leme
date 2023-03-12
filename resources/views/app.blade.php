<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('titulo')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <nav class="navbar bg-dark navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 39.726" width="131" alt="Logo da Leme">
                        <g fill="#fff" data-name="Grupo 3001">
                            <path d="m75.136 31.289-1.584 4.426a6.7 6.7 0 0 0-1.471-.225H57.736v-.3a3.518 3.518 0 0 0 .685-2.044v-21.79a3.441 3.441 0 0 0-.685-2.044v-.3h4.235v.3a4.37 4.37 0 0 0-.685 2.044v22.015h8.626a6.73 6.73 0 0 0 5.066-2.19Z" data-name="Caminho 22613"></path>
                            <path d="m103.726 31.288-1.587 4.425a6.7 6.7 0 0 0-1.471-.225H86.339v-.3a3.518 3.518 0 0 0 .685-2.044V11.352a3.441 3.441 0 0 0-.685-2.044v-.3h13.107a5.15 5.15 0 0 0 2.078-.27h.146v4.358h-.146c-.719-1.516-1.55-1.966-3.785-1.966h-7.85v8.019h7.626a2.673 2.673 0 0 0 1.325-.337h.146v3.066h-.147a5.36 5.36 0 0 0-2.269-.607h-6.681v12.1h8.626a6.729 6.729 0 0 0 5.065-2.19Z" data-name="Caminho 22614"></path>
                            <path d="m180 31.288-1.587 4.425a6.7 6.7 0 0 0-1.471-.225h-14.329v-.3a3.518 3.518 0 0 0 .685-2.044V11.352a3.441 3.441 0 0 0-.685-2.044v-.3h13.107a5.15 5.15 0 0 0 2.078-.27h.146v4.358h-.146c-.719-1.516-1.55-1.966-3.785-1.966h-7.85v8.019h7.626a2.673 2.673 0 0 0 1.325-.337h.146v3.066h-.147a5.36 5.36 0 0 0-2.269-.607h-6.681v12.1h8.626a6.729 6.729 0 0 0 5.065-2.19Z" data-name="Caminho 22615"></path>
                            <path d="M146.458 30.49a8.63 8.63 0 0 0 1.325 4.695v.3h-4.762a8.465 8.465 0 0 0 .494-4.392l-1.168-18.982-10.479 23.744h-.3l-10.131-23.822-1.247 19.06a8.486 8.486 0 0 0 .494 4.392h-4.126v-.3a8.726 8.726 0 0 0 1.325-4.695l1.325-19.139a2.3 2.3 0 0 0-.831-2.044v-.3h4.919l8.884 20.992 9.154-20.992h4.65v.3a2.291 2.291 0 0 0-.831 2.044Z" data-name="Caminho 22616"></path>
                            <path d="M101.7 3.212v1.555H86.339V3.212Z" data-name="Caminho 22624"></path>
                        </g>
                        <g data-name="Grupo 3002">
                            <path fill="#fff" d="M19.069 0h1.589v15.361h-1.589Z" data-name="Caminho 22622"></path>
                            <path fill="#fff" d="M24.366 19.069h15.361v1.589H24.366Z" data-name="Caminho 22617"></path>
                            <path fill="#fff" d="M0 19.069h15.361v1.589H0Z" data-name="Caminho 22618"></path>
                            <path fill="#fff" d="M19.069 24.366h1.589v15.361h-1.589Z" data-name="Caminho 22623"></path>
                            <path fill="#fff" d="M15.358 16.483 5.253 6.378l1.124-1.121 10.1 10.107h-1.119v1.119Z" data-name="Caminho 22619"></path>
                            <path fill="#e5695b" d="m33.346 5.256-28.09 28.09 1.123 1.125L34.47 6.38Z" data-name="Caminho 22620"></path>
                            <path fill="#fff" d="m33.347 34.468-10.1-10.1h1.124v-1.125l10.1 10.1-1.124 1.125Z" data-name="Caminho 22621"></path>
                        </g>
                    </svg>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('clientes.index') }}">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('pedidos.index') }}">Pedidos</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <br><br>
            @yield('conteudo')
        </div>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</html>