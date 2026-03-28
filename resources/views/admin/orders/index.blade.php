@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
    <h1>Commandes</h1>

    <form method="get" style="margin-bottom: 1rem;">
        <select name="status" class="form-control" style="max-width: 180px; display: inline-block;">
            <option value="">Tous les statuts</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>En cours</option>
            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Expédié</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Livré</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
        </select>
        <select name="payment" class="form-control" style="max-width: 180px; display: inline-block;">
            <option value="">Tous les paiements</option>
            <option value="pending" {{ request('payment') == 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Payé</option>
        </select>
        <button type="submit" class="btn btn-outline">Filtrer</button>
    </form>

    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Client</th>
                <th>Total</th>
                <th>Paiement</th>
                <th>Statut</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ number_format($order->total, 0, '', ' ') }} F</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline" title="Voir"><i class="fas fa-eye"></i></a></td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    {{ $orders->withQueryString()->links() }}
@endsection
