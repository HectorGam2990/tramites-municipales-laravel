@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="mb-0">Trámites</h1>
            <small class="text-muted">Registro y seguimiento de trámites.</small>
        </div>
        <a href="{{ route('procedures.create') }}" class="btn btn-primary">+ Nuevo trámite</a>
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

    <form class="row g-2 mb-3" method="GET" action="{{ route('procedures.index') }}">
        <div class="col-sm-9">
            <input type="text" name="search" class="form-control"
                   placeholder="Buscar por folio, estatus, ciudadano o tipo..." value="{{ $search }}">
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
                            <th>Folio</th>
                            <th>Ciudadano</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($procedures as $p)
                            <tr>
                                <td class="fw-semibold">{{ $p->folio }}</td>
                                <td>
                                    {{ $p->citizen?->full_name }}
                                    <div class="small text-muted">{{ $p->citizen?->curp }}</div>
                                </td>
                                <td>{{ $p->procedureType?->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->submitted_at)->format('d/m/Y') }}</td>

                                {{-- ✅ Estatus rápido --}}
                                <td style="min-width: 180px;">
                                    @php
                                        $badge = match($p->status) {
                                            'aprobado' => 'success',
                                            'rechazado' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp

                                    <div class="d-flex flex-column gap-1">
                                        <span class="badge bg-{{ $badge }}">{{ ucfirst($p->status) }}</span>

                                        <form method="POST" action="{{ route('procedures.status', $p) }}">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm status-select">
                                                @foreach (['pendiente','aprobado','rechazado'] as $st)
                                                    <option value="{{ $st }}" @selected($p->status === $st)>{{ ucfirst($st) }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('procedures.edit', $p) }}" class="btn btn-sm btn-outline-primary">Editar</a>

                                    <form action="{{ route('procedures.destroy', $p) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este trámite?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No hay trámites registrados todavía.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($procedures->hasPages())
            <div class="card-footer">
                {{ $procedures->links() }}
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.status-select').forEach(sel => {
    sel.addEventListener('change', () => {
      sel.closest('form').submit();
    });
  });
});
</script>
@endsection
