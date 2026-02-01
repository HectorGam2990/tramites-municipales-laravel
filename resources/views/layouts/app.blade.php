<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trámites Municipales</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Trámites</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('citizens.index') }}">Ciudadanos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('procedure-types.index') }}">Tipos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('procedures.index') }}">Trámites</a></li>
            </ul>

            @auth
            <div class="d-flex align-items-center gap-2 text-white">
                <span class="small">{{ auth()->user()->name }}</span>

                <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm">Perfil</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Salir</button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
