@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <div class="container">
    <section class="hero-agri">
        <div class="hero-left">
            <h1>Produits agricoles frais, directement des éleveurs</h1>
            <p class="hero-desc">Découvrez les meilleurs produits locaux. Viandes, lait frais, fromages artisanaux, yaourt et aliments pour bétail.</p>
            <div class="hero-buttons">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Explorer les produits</a>
                <a href="{{ route('contact') }}" class="btn btn-outline">Nous contacter</a>
            </div>
        </div>
        <div class="hero-right">
            <div class="map-placeholder">
                <i class="fas fa-map-marker-alt"></i>
                <div><strong>Où nous trouver</strong></div>
                <div>Dakar, Sénégal</div>
            </div>
        </div>
    </section>

    <h2 class="section-title">Catégories</h2>
    <div class="categories-row">
        @php
            $catIcons = [
                'Viande poulet locale' => 'fa-drumstick-bite',
                'Viande caille' => 'fa-utensils',
                'Viande agneau' => 'fa-bone',
                'Vente de lait' => 'fa-wine-bottle',
                'Lait caillé, yaourt, fromage locale' => 'fa-cheese',
                'Aliment de bétail' => 'fa-wheat-awn',
                'Vente de poussin Goliath' => 'fa-egg',
            ];
        @endphp
        @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="category-card">
                <i class="fas {{ $catIcons[$cat->name] ?? 'fa-tag' }}"></i>
                <span>{{ Str::limit($cat->name, 18) }}</span>
            </a>
        @endforeach
    </div>

    <div class="section-head">
        <h2 class="section-title">Produits à proximité</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">Voir tout</a>
    </div>
    <div class="products-row">
        @foreach($featuredProducts as $p)
            <div class="product-card-agri">
                <a href="{{ route('products.show', $p->slug) }}" style="text-decoration: none; color: inherit;">
                    <img src="{{ $p->display_image }}" alt="{{ $p->name }}" class="card-img" style="height: 160px; object-fit: cover;">
                    <div class="card-body">
                        <div class="card-title">{{ $p->name }} - {{ $p->unit }}</div>
                        <p class="card-meta"><i class="fas fa-map-marker-alt"></i> Dakar · <i class="fas fa-star"></i> 4.8</p>
                        <span class="price-cfa">{{ number_format($p->price, 0, '', ' ') }} CFA</span>
                    </div>
                </a>
                @if($p->stock > 0)
                    <div class="card-actions">
                        <button type="button" class="btn-add add-to-cart" data-id="{{ $p->id }}" data-name="{{ $p->name }}" data-slug="{{ $p->slug }}" data-price="{{ $p->price }}" data-unit="{{ $p->unit }}" data-stock="{{ $p->stock }}" title="Ajouter au panier"><i class="fas fa-plus"></i></button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    </div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.add-to-cart').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        var id = this.dataset.id, name = this.dataset.name, slug = this.dataset.slug, price = parseFloat(this.dataset.price), unit = this.dataset.unit, stock = parseInt(this.dataset.stock, 10);
        var key = 'lahad_cart';
        var cart = [];
        try { cart = JSON.parse(localStorage.getItem(key) || '[]'); } catch (e) {}
        var i = cart.findIndex(function(x) { return x.id == id; });
        var qty = (i >= 0 ? cart[i].quantity : 0) + 1;
        qty = Math.min(qty, stock);
        if (i >= 0) cart[i].quantity = qty; else cart.push({ id: id, name: name, slug: slug, price: price, unit: unit, quantity: qty, stock: stock });
        localStorage.setItem(key, JSON.stringify(cart));
        if (window.lahadCartCount) window.lahadCartCount();
    });
});
</script>
@endpush
