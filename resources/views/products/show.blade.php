@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <p><a href="{{ route('products.index') }}" class="back-link">&larr; Produits</a></p>
    <div class="product-detail-grid">
        <div class="product-detail-image">
            <img src="{{ $product->display_image }}" alt="{{ $product->name }}" style="width: 100%; height: 400px; object-fit: cover; border-radius: var(--radius); box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        </div>
        <div class="product-detail-info">
            <h1 class="page-title">{{ $product->name }}</h1>
            <p class="product-category">{{ $product->category->name }}</p>
            <p class="price-cfa" style="font-size: 1.5rem;">{{ number_format($product->price, 0, '', ' ') }} CFA <span class="unit">/ {{ $product->unit }}</span></p>
            @if($product->description)
                <p>{{ $product->description }}</p>
            @endif
            @if($product->stock > 0)
                <div class="form-group">
                    <label>Quantité</label>
                    <input type="number" id="qty" min="0.01" max="{{ $product->stock }}" step="0.01" value="1" class="form-control" style="max-width: 120px;">
                </div>
                <button type="button" class="btn btn-primary add-to-cart" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-slug="{{ $product->slug }}" data-price="{{ $product->price }}" data-unit="{{ $product->unit }}" data-stock="{{ $product->stock }}">Ajouter au panier</button>
            @else
                <span class="badge" style="background:#f8d7da;">Rupture de stock</span>
            @endif
        </div>
    </div>

    @if($related->isNotEmpty())
        <h2 class="section-title">Produits similaires</h2>
        <div class="grid grid-4">
            @foreach($related as $p)
                <a href="{{ route('products.show', $p->slug) }}" class="card product-card" style="text-decoration: none; color: inherit;">
                    <img src="{{ $p->display_image }}" alt="{{ $p->name }}" style="width: 100%; height: 140px; object-fit: cover; border-top-left-radius: var(--radius); border-top-right-radius: var(--radius);">
                    <div class="card-body">
                        <div class="card-title">{{ $p->name }}</div>
                        <span class="price">{{ number_format($p->price, 0, '', ' ') }} F</span> / {{ $p->unit }}
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection

@push('scripts')
<script>
document.querySelector('.add-to-cart') && document.querySelector('.add-to-cart').addEventListener('click', function() {
    var qty = parseFloat(document.getElementById('qty').value) || 1;
    var btn = this;
    var id = btn.dataset.id, name = btn.dataset.name, slug = btn.dataset.slug, price = parseFloat(btn.dataset.price), unit = btn.dataset.unit, stock = parseInt(btn.dataset.stock, 10);
    qty = Math.min(Math.max(0.01, qty), stock);
    var key = 'lahad_cart';
    var cart = [];
    try { cart = JSON.parse(localStorage.getItem(key) || '[]'); } catch (e) {}
    var i = cart.findIndex(function(x) { return x.id == id; });
    if (i >= 0) cart[i].quantity += qty; else cart.push({ id: id, name: name, slug: slug, price: price, unit: unit, quantity: qty, stock: stock });
    cart.find(function(x) { return x.id == id; }).quantity = Math.min(cart.find(function(x) { return x.id == id; }).quantity, stock);
    localStorage.setItem(key, JSON.stringify(cart));
    if (window.lahadCartCount) window.lahadCartCount();
    if (typeof window.showToast === 'function') {
        window.showToast(name + ' a été ajouté au panier !', 'success');
    }
});
</script>
@endpush
