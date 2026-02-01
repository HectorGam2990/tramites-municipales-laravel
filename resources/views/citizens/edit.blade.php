@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Editar ciudadano</h1>
        <a href="{{ route('citizens.index') }}" class="btn btn-outline-dark">← Volver</a>
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
            <form method="POST" action="{{ route('citizens.update', $citizen) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="full_name" class="form-control"
                           value="{{ old('full_name', $citizen->full_name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">CURP</label>
                    <input type="text" name="curp" class="form-control text-uppercase"
                           value="{{ old('curp', $citizen->curp) }}" required maxlength="18">
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $citizen->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $citizen->email) }}">
                </div>

                <button class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>
@endsection
