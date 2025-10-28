@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            
            {{-- Tarjeta con diseño moderno --}}
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">

                    {{-- Encabezado del Formulario --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Escuelita" style="height: 60px; margin-bottom: 1rem;">
                        <h3 class="font-weight-bold text-dark">{{ __('Bienvenido de Nuevo') }}</h3>
                        <p class="text-muted">Ingresa tus credenciales para acceder</p>
                    </div>

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Campo de Correo con Icono --}}
                        <div class="input-group mb-4 shadow-sm">
                            <span class="input-group-text bg-light text-muted border-0">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input id="email" type="email" class="form-control form-control-lg border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo Electrónico">
                        </div>
                        @error('email')
                            <span class="d-block invalid-feedback text-center mb-3" role="alert">
                                <strong>{{ "El correo es incorrecto" }}</strong>
                            </span>
                        @enderror

                        {{-- Campo de Contraseña con Icono --}}
                        <div class="input-group mb-4 shadow-sm">
                            <span class="input-group-text bg-light text-muted border-0">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="password" type="password" class="form-control form-control-lg border-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                        </div>
                        @error('password')
                            <span class="d-block invalid-feedback text-center mb-3" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        {{-- Checkbox de Recuérdame --}}
                        <div class="row">
                            <div class="col-7">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="remember">
                                        {{ __('Recuérdame') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-5 text-end">
                                @if (Route::has('password.request'))
                                    <a class="btn-link-custom" href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Botón de Envío --}}
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary-custom btn-lg font-weight-bold">
                                {{ __('Iniciar sesión') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection