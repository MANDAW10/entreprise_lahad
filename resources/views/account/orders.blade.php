@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')
    <h1>Historique des commandes</h1>
    <p><a href="{{ route('account.index') }}">&larr; Retour au compte</a></p>

    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>N° commande</th>
                <th>Date</th>
                <th>Total</th>
                <th>Statut</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($order->total, 0, '', ' ') }} F</td>
                    <td><span class="badge">{{ $order->status }}</span></td>
                    <td><a href="{{ route('account.orders.show', $order) }}" class="btn btn-sm btn-outline">Détail</a></td>
                </tr>
            @empty
                <tr><td colspan="5">Aucune commande.</td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
    {{ $orders->links() }}
@endsection
