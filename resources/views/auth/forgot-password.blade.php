@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <button type="submit" class="btn btn-dark w-100">Enviar enlace de recuperación</button>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-decoration-none">Volver al inicio de sesión</a>
    </div>
</form>
@endsection
