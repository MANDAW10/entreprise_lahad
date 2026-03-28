@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-unlock-alt"></i>
            </div>
            <h1>Mot de passe oublié</h1>
            <p>Renseignez votre email et votre numéro de téléphone pour créer un nouveau mot de passe instantanément.</p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label>Adresse Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="khadija@email.com" required autofocus>
                @error('email')
                    <span style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Numéro de téléphone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Ex: 77 123 45 67" required>
            </div>
            
            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                @error('password')
                    <span style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="margin-top: 1rem; padding: 1rem; font-size: 1.1rem; width: 100%;">
                Modifier mon mot de passe <i class="fas fa-check" style="margin-left: 0.5rem;"></i>
            </button>
        </form>

        <div class="auth-footer" style="margin-top: 2rem;">
            <a href="{{ route('login') }}">&larr; Retour à la connexion</a>
        </div>
    </div>
</div>
@endsection
