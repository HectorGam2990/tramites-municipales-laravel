@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Editar trámite</h1>
        <a href="{{ route('procedures.index') }}" class="btn btn-outline-dark">← Volver</a>
    </div>

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

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('procedures.update', $procedure) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Folio</label>
                    <input type="text" class="form-control" value="{{ $procedure->folio }}" disabled>
                    <div class="form-text">El folio se genera automáticamente y no se edita.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ciudadano</label>
                    <select name="citizen_id" class="form-select" required>
                        <option value="">Selecciona...</option>
                        @foreach ($citizens as $c)
                            <option value="{{ $c->id }}"
                                @selected(old('citizen_id', $procedure->citizen_id) == $c->id)>
                                {{ $c->full_name }} ({{ $c->curp }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de trámite</label>
                    <select name="procedure_type_id" class="form-select" required>
                        <option value="">Selecciona...</option>
                        @foreach ($types as $t)
                            <option value="{{ $t->id }}"
                                @selected(old('procedure_type_id', $procedure->procedure_type_id) == $t->id)>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de solicitud</label>
                    <input type="date" name="submitted_at" class="form-control"
                           value="{{ old('submitted_at', \Carbon\Carbon::parse($procedure->submitted_at)->toDateString()) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estatus</label>
                    <select name="status" class="form-select" required>
                        @foreach (['pendiente','aprobado','rechazado'] as $st)
                            <option value="{{ $st }}" @selected(old('status', $procedure->status) === $st)>
                                {{ ucfirst($st) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $procedure->notes) }}</textarea>
                </div>

                <button class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>
@endsection
