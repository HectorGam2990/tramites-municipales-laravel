@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Editar tipo de trámite</h1>
        <a href="{{ route('procedure-types.index') }}" class="btn btn-outline-dark">← Volver</a>
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
            <form method="POST" action="{{ route('procedure-types.update', $type) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $type->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $type->description) }}</textarea>
                </div>

                <button class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>
@endsection
