@extends('layouts.app')

@section('title', 'Mon compte')

@section('content')
    <h1>Mon compte</h1>
    <p>Bienvenue, {{ $user->name }}.</p>

    <div style="display: grid; gap: 1.5rem; max-width: 600px;">
        <div class="card">
            <div class="card-body">
                <h2 style="margin-top: 0;">Profil</h2>
                <form method="post" action="{{ route('account.update') }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="form-group">
                        <label>Adresse</label>
                        <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 style="margin-top: 0;">Dernières commandes</h2>
                <a href="{{ route('account.orders') }}">Voir tout l'historique</a>
                <ul style="list-style: none; padding: 0; margin: 0.5rem 0 0;">
                    @forelse($orders as $order)
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid var(--border);">
                            <a href="{{ route('account.orders.show', $order) }}">{{ $order->order_number }}</a>
                            — {{ number_format($order->total, 0, '', ' ') }} F — {{ $order->status }}
                        </li>
                    @empty
                        <li>Aucune commande.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
