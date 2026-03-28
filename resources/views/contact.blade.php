@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
<div class="container main-content">
    
    <div class="contact-hero">
        <h1>Entrons en contact</h1>
        <p>Avez-vous des questions sur nos produits, besoin d'aide pour une commande, ou envie de devenir partenaire agricole ? Nous sommes là pour vous aider !</p>
    </div>

    <div class="contact-layout">
        <!-- Informations de contact -->
        <div class="contact-info-col">
            <div class="contact-info-card">
                <div class="contact-info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-info-text">
                    <h3>Notre ferme</h3>
                    <p>Route des Niayes, Km 15<br>Dakar, Sénégal</p>
                </div>
            </div>

            <div class="contact-info-card">
                <div class="contact-info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-info-text">
                    <h3>Email</h3>
                    <p><a href="mailto:contact@lahad-enterprise.sn">contact@lahad-enterprise.sn</a><br><a href="mailto:support@lahad.sn" style="font-size: 0.9rem">support@lahad.sn</a></p>
                </div>
            </div>

            <div class="contact-info-card">
                <div class="contact-info-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="contact-info-text">
                    <h3>Appelez-nous</h3>
                    <p><a href="tel:+221770000000">+221 77 000 00 00</a><br><strong style="font-size: 0.85rem; color: var(--primary);">Du Lun au Sam, 8h - 18h</strong></p>
                </div>
            </div>
        </div>

        <!-- Formulaire de contact -->
        <div class="contact-form-card">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
                </div>
            @endif

            <form method="post" action="{{ route('contact.send') }}">
                @csrf
                <div class="grid-2" style="gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Nom complet</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ex: Khadija Fall" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Adresse Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Ex: khadija@email.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Sujet de votre message</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="Ex: Question sur les agneaux" required>
                </div>
                <div class="form-group">
                    <label>Votre Message</label>
                    <textarea name="message" class="form-control" placeholder="Comment pouvons-nous vous aider aujourd'hui ?" style="min-height: 150px;" required>{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane" style="margin-right: 0.5rem;"></i> Envoyer le message
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
