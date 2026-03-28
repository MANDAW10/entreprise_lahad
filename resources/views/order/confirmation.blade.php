@extends('layouts.app')

@section('title', 'Commande confirmée')

@section('content')
    <div class="alert alert-success">
        <h1>Commande enregistrée</h1>
        <p>Votre commande <strong>{{ $order->order_number }}</strong> a bien été enregistrée.</p>
        <p>Total : <strong>{{ number_format($order->total, 0, '', ' ') }} F</strong></p>
        <p>Vous recevrez un email de confirmation. Pour suivre votre commande, <a href="{{ route('login') }}">connectez-vous</a> ou <a href="{{ route('register') }}">créez un compte</a>.</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-primary">Retour à l'accueil</a>
    <a href="{{ route('products.index') }}" class="btn btn-outline">Continuer les achats</a>
@endsection
