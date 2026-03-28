@extends('layouts.app')

@section('title', 'Commande ' . $order->order_number)

@section('content')
    <h1>Commande {{ $order->order_number }}</h1>
    <p><a href="{{ route('account.orders') }}">&larr; Mes commandes</a></p>

    <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Statut :</strong> {{ $order->status }}</p>
    <p><strong>Paiement :</strong> {{ $order->payment_status }}</p>

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
    <p class="cart-total">Total : {{ number_format($order->total, 0, '', ' ') }} F</p>
@endsection
