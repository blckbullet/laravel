@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100 align-items-center justify-content-center">
        
        <div class="col-lg-5 col-md-7">
            <div class="card login-card shadow-xl border-0">
                <div class="card-body p-lg-5 p-4">

                    @if (session('status'))
                        {{-- Mensaje de Éxito con Estilo Personalizado --}}
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h3 class="font-weight-bold text-dark">{{ __('Enlace Enviado') }}</h3>
                            <div class="alert alert-custom-success mt-3" role="alert">
                                {{ session('status') }}
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary-custom mt-4">Volver a Inicio de Sesión</a>
                        </div>
                    @else
                        {{-- Formulario para Solicitar el Enlace --}}
                        <div class="text-center mb-4">
                            <i class="fas fa-paper-plane fa-3x text-primary-custom mb-3"></i>
                            <h3 class="font-weight-bold text-dark">{{ __('Restablecer Contraseña') }}</h3>
                            <p class="text-muted">No te preocupes. Ingresa tu correo y te enviaremos un enlace para recuperarla.</p>
                        </div>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-floating mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="correo@ejemplo.com">
                                <label for="email"><i class="fas fa-envelope me-2"></i>{{ __('Correo Electrónico') }}</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid my-4">
                                <button type="submit" class="btn btn-primary-custom btn-lg font-weight-bold">
                                    {{ __('ENVIAR ENLACE') }}
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="btn-link-custom ms-1">Recordé mi contraseña</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection