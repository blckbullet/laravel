@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100 align-items-center justify-content-center">
        
        <div class="col-lg-8 col-md-10">
            <div class="card login-card shadow-xl border-0">
                <div class="row g-0">

                    <div class="col-md-5 branding-panel d-none d-md-flex">
                        <div class="text-BLACK text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Escuelita" style="width: 80px; margin-bottom: 1.5rem;">
                            <h2 class="h1 font-weight-bold">Únete a la Comunidad</h2>
                            <p class="lead mt-3">Crea tu cuenta para empezar a gestionar el futuro de la educación.</p>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card-body p-lg-5 p-4">
                            <h3 class="font-weight-bold text-dark mb-4">{{ __('Crear una Cuenta') }}</h3>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-floating mb-3">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre Completo">
                                    <label for="name"><i class="fas fa-user me-2"></i>{{ __('Nombre Completo') }}</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="correo@ejemplo.com">
                                    <label for="email"><i class="fas fa-envelope me-2"></i>{{ __('Correo Electrónico') }}</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">
                                    <label for="password"><i class="fas fa-lock me-2"></i>{{ __('Contraseña') }}</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-4">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Contraseña">
                                    <label for="password-confirm"><i class="fas fa-check-circle me-2"></i>{{ __('Confirmar Contraseña') }}</label>
                                </div>

                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary-custom btn-lg font-weight-bold">
                                        {{ __('CREAR CUENTA') }}
                                    </button>
                                </div>

                                <div class="text-center">
                                    <span class="text-muted small">¿Ya tienes una cuenta?</span>
                                    <a href="{{ route('login') }}" class="btn-link-custom ms-1">Inicia sesión</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection