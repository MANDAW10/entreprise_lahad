@extends('layouts.admin')

@section('title', 'Commande ' . $order->order_number)

@section('content')
    <h1>Commande {{ $order->order_number }}</h1>
    <p><a href="{{ route('admin.orders.index') }}">&larr; Liste des commandes</a></p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
        <div class="card">
            <div class="card-body">
                <h3 style="margin-top: 0;">Client</h3>
                <p><strong>{{ $order->customer_name }}</strong><br>
                {{ $order->customer_email }}<br>
                {{ $order->customer_phone }}</p>
                <p><strong>Adresse livraison :</strong><br>{{ $order->shipping_address }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 style="margin-top: 0;">Statuts</h3>
                <form method="post" action="{{ route('admin.orders.status', $order) }}" style="margin-bottom: 1rem;">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Statut commande</label>
                        <select name="status" class="form-control" style="max-width: 200px;">
                            @foreach(['pending' => 'En attente', 'processing' => 'En cours', 'shipped' => 'Expédié', 'delivered' => 'Livré', 'cancelled' => 'Annulé'] as $v => $l)
                                <option value="{{ $v }}" {{ $order->status == $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
                </form>
                <form method="post" action="{{ route('admin.orders.payment', $order) }}">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Statut paiement</label>
                        <select name="payment_status" class="form-control" style="max-width: 200px;">
                            @foreach(['pending' => 'En attente', 'paid' => 'Payé', 'failed' => 'Échoué', 'refunded' => 'Remboursé'] as $v => $l)
                                <option value="{{ $v }}" {{ $order->payment_status == $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
                </form>
                <p style="margin-top: 0.5rem;">Méthode : {{ $order->payment_method ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ number_format($item->price, 0, '', ' ') }} F / {{ $item->unit }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->total, 0, '', ' ') }} F</td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <p class="cart-total">Sous-total : {{ number_format($order->subtotal, 0, '', ' ') }} F — Livraison : {{ number_format($order->shipping_cost, 0, '', ' ') }} F — <strong>Total : {{ number_format($order->total, 0, '', ' ') }} F</strong></p>
    @if($order->notes)
        <p><strong>Notes :</strong> {{ $order->notes }}</p>
    @endif
@endsection
