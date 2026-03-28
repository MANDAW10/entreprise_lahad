@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card large">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-leaf"></i>
            </div>
            <h1>Créer un compte</h1>
            <p>Remplissez le formulaire pour démarrer.</p>
        </div>

        <form method="post" action="{{ route('register') }}" class="auth-form">
            @csrf
            
            <div class="grid-2">
                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Khadija Fall" required>
                </div>
                <div class="form-group">
                    <label>Adresse Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="khadija@email.com" required>
                </div>
            </div>

            <div class="grid-2" style="margin-top: 0.5rem;">
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label>Confirmation</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <div class="grid-2" style="margin-top: 0.5rem;">
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+221 77 000 00 00" required>
                </div>
                <div class="form-group">
                    <label>Adresse complète</label>
                    <textarea name="address" class="form-control" placeholder="Quartier, Rue, N° Villa" style="min-height: 48px; padding-top: 0.5rem;" required>{{ old('address') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 1rem; width: 100%;">
                S'inscrire maintenant <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
            </button>
        </form>

        <div class="auth-footer" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border); text-align: center;">
            Vous avez déjà un compte ? <a href="{{ route('login') }}" style="margin-left: 0.25rem;">Se connecter</a>
        </div>
    </div>
</div>
@endsection
