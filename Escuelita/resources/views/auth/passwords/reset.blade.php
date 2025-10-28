@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100 align-items-center justify-content-center">
        
        <div class="col-lg-8 col-md-10">
            <div class="card login-card shadow-xl border-0">
                <div class="row g-0">

                    <div class="col-md-5 branding-panel d-none d-md-flex">
                        <div class="text-white text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Escuelita" style="width: 80px; margin-bottom: 1.5rem;">
                            <h2 class="h1 font-weight-bold">Restablece tu Contraseña</h2>
                            <p class="lead mt-3">Un paso más y tendrás acceso de nuevo. La seguridad de tu cuenta es nuestra prioridad.</p>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card-body p-lg-5 p-4">
                            <h3 class="font-weight-bold text-dark mb-4">{{ __('Define tu nueva contraseña') }}</h3>

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                {{-- Este campo es invisible pero crucial para el proceso --}}
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-floating mb-3">
                                    {{-- El campo de email viene pre-llenado y lo ponemos como solo lectura por seguridad --}}
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
                                    <label for="email"><i class="fas fa-envelope me-2"></i>{{ __('Correo Electrónico') }}</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nueva Contraseña" autofocus>
                                    <label for="password"><i class="fas fa-lock me-2"></i>{{ __('Nueva Contraseña') }}</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-4">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Nueva Contraseña">
                                    <label for="password-confirm"><i class="fas fa-check-circle me-2"></i>{{ __('Confirmar Nueva Contraseña') }}</label>
                                </div>

                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary-custom btn-lg font-weight-bold">
                                        {{ __('GUARDAR NUEVA CONTRASEÑA') }}
                                    </button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="btn-link-custom ms-1">Volver a inicio de sesión</a>
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