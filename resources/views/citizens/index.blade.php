@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="mb-0">Ciudadanos</h1>
            <small class="text-muted">Administra el padrón de ciudadanos.</small>
        </div>
        <a href="{{ route('citizens.create') }}" class="btn btn-primary">+ Nuevo ciudadano</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa los datos:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="row g-2 mb-3" method="GET" action="{{ route('citizens.index') }}">
        <div class="col-sm-9">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por nombre, CURP, teléfono o correo..."
                value="{{ $search }}"
            >
        </div>
        <div class="col-sm-3 d-grid">
            <button class="btn btn-outline-dark">Buscar</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>CURP</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($citizens as $citizen)
                            <tr>
                                <td>{{ $citizen->full_name }}</td>
                                <td class="text-uppercase">{{ $citizen->curp }}</td>
                                <td>{{ $citizen->phone ?? '—' }}</td>
                                <td>{{ $citizen->email ?? '—' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('citizens.edit', $citizen) }}" class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>

                                    <form action="{{ route('citizens.destroy', $citizen) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este ciudadano?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No hay ciudadanos registrados todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($citizens->hasPages())
            <div class="card-footer">
                {{ $citizens->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
