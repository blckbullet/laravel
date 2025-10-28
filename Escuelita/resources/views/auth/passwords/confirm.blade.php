@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100 align-items-center justify-content-center">
        
        {{-- Usamos una columna más pequeña para una tarjeta más enfocada --}}
        <div class="col-lg-5 col-md-7">
            <div class="card login-card shadow-xl border-0">
                <div class="card-body p-lg-5 p-4">

                    {{-- Encabezado del Formulario --}}
                    <div class="text-center mb-4">
                        <i class="fas fa-shield-alt fa-3x text-primary-custom mb-3"></i>
                        <h3 class="font-weight-bold text-dark">{{ __('Confirmar Contraseña') }}</h3>
                        <p class="text-muted">Por tu seguridad, necesitamos verificar tu identidad antes de continuar.</p>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña" autofocus>
                            <label for="password"><i class="fas fa-lock me-2"></i>{{ __('Contraseña') }}</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid my-4">
                            <button type="submit" class="btn btn-primary-custom btn-lg font-weight-bold">
                                {{ __('CONFIRMAR CONTRASEÑA') }}
                            </button>
                        </div>
                        
                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <a class="btn-link-custom" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection