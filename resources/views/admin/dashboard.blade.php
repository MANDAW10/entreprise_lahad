@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $stats['orders_count'] }}</div>
            <div class="label">Commandes totales</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $stats['orders_today'] }}</div>
            <div class="label">Commandes aujourd'hui</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ number_format($stats['total_revenue'], 0, '', ' ') }} F</div>
            <div class="label">Chiffre d'affaires (payé)</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $stats['products_count'] }}</div>
            <div class="label">Produits</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $stats['low_stock'] }}</div>
            <div class="label">Stock faible</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $stats['out_of_stock'] }}</div>
            <div class="label">Rupture</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $stats['customers_count'] }}</div>
            <div class="label">Clients</div>
        </div>
    </div>

    <h2 style="margin-top: 2rem;">Chiffre d'affaires par mois</h2>
    <div class="chart-container">
        <canvas id="chartRevenue" width="400" height="200"></canvas>
    </div>

    <h2>Top produits vendus</h2>
    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Chiffre d'affaires</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $p)
                <tr>
                    <td>{{ $p->product_name }}</td>
                    <td>{{ $p->qty }}</td>
                    <td>{{ number_format($p->revenue, 0, '', ' ') }} F</td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>

    <h2>Dernières commandes</h2>
    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Client</th>
                <th>Total</th>
                <th>Statut</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ number_format($order->total, 0, '', ' ') }} F</td>
                    <td>{{ $order->status }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline" title="Voir"><i class="fas fa-eye"></i></a></td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function() {
    var data = @json($revenueByMonth);
    if (data.length) {
        var ctx = document.getElementById('chartRevenue');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: data.map(function(d) { return d.month; }),
                    datasets: [{ label: 'CA (F)', data: data.map(function(d) { return parseFloat(d.total); }), backgroundColor: 'rgba(45, 90, 39, 0.7)' }]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        }
    }
})();
</script>
@endpush
