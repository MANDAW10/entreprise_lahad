@extends('layouts.app')

@section('title', 'Produits')

@section('content')
    <div class="container">
    <h1 class="page-title">Boutique</h1>

    <form method="get" action="{{ route('products.index') }}" class="filter-bar">
        <input type="text" name="q" class="form-control" placeholder="Rechercher des produits, catégories..." value="{{ request('q') }}">
        <select name="category" class="form-control">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filtrer</button>
    </form>

    <div class="products-row">
        @forelse($products as $p)
            <div class="product-card-agri">
                <a href="{{ route('products.show', $p->slug) }}" style="text-decoration: none; color: inherit;">
                    <img src="{{ $p->display_image }}" alt="{{ $p->name }}" class="card-img" style="height: 160px; object-fit: cover;">
                    <div class="card-body">
                        <div class="card-title">{{ $p->name }} - {{ $p->unit }}</div>
                        <p class="card-meta"><i class="fas fa-map-marker-alt"></i> Dakar · <i class="fas fa-star"></i> 4.8</p>
                        <span class="price-cfa">{{ number_format($p->price, 0, '', ' ') }} CFA</span>
                        @if($p->stock <= 0)
                            <span class="badge" style="background:#f8d7da; margin-top: 0.5rem;">Rupture</span>
                        @elseif($p->low_stock)
                            <span class="badge badge-warning" style="margin-top: 0.5rem;">Stock faible</span>
                        @endif
                    </div>
                </a>
                @if($p->stock > 0)
                    <div class="card-actions">
                        <button type="button" class="btn-add add-to-cart" data-id="{{ $p->id }}" data-name="{{ $p->name }}" data-slug="{{ $p->slug }}" data-price="{{ $p->price }}" data-unit="{{ $p->unit }}" data-stock="{{ $p->stock }}" title="Ajouter au panier"><i class="fas fa-plus"></i></button>
                    </div>
                @endif
            </div>
        @empty
            <p>Aucun produit trouvé.</p>
        @endforelse
    </div>

    {{ $products->withQueryString()->links() }}
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
        
        if (typeof window.showToast === 'function') {
            window.showToast(name + ' a été ajouté au panier !', 'success');
        }
    });
});
</script>
@endpush
