@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-leaf"></i>
            </div>
            <h1>Bon retour !</h1>
            <p>Connectez-vous pour accéder à votre espace Lahad Enterprise</p>
        </div>

        <form method="post" action="{{ url('/connexion') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <label>Adresse Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="khadija@email.com" required autofocus>
            </div>
            
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <div class="form-group" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                <label style="text-transform: none; letter-spacing: normal; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; margin: 0; font-weight: 500;">
                    <input type="checkbox" name="remember" style="width: 16px; height: 16px; accent-color: var(--orange);"> 
                    Se souvenir de moi
                </label>
                <a href="{{ route('password.request') }}" style="font-size: 0.9rem; color: var(--primary); text-decoration: none; font-weight: 600;">Mot de passe oublié ?</a>
            </div>
            
            <button type="submit" class="btn btn-primary">
                Se connecter <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
            </button>
        </form>

        <div class="auth-footer">
            Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>
</div>
@endsection
