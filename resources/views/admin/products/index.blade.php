@extends('layouts.admin')

@section('title', 'Produits')

@section('content')
    <h1>Produits</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Nouveau produit</a>

    <form method="get" action="{{ route('admin.products.index') }}" style="margin: 1rem 0;">
        <select name="category" class="form-control" style="max-width: 250px; display: inline-block;">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-outline">Filtrer</button>
    </form>

    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actif</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td>
                        @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div style="width: 50px; height: 50px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 0.8rem;">N/A</div>
                        @endif
                    </td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name }}</td>
                    <td>{{ number_format($p->price, 0, '', ' ') }} F / {{ $p->unit }}</td>
                    <td>
                        {{ $p->stock }}
                        @if($p->stock <= $p->stock_alert && $p->stock > 0)
                            <span class="badge badge-warning">Alerte</span>
                        @elseif($p->stock == 0)
                            <span class="badge" style="background:#f8d7da;">Rupture</span>
                        @endif
                    </td>
                    <td>{{ $p->is_active ? 'Oui' : 'Non' }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline" title="Modifier"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.products.destroy', $p) }}" method="post" style="display:inline;" onsubmit="return confirm('Supprimer ce produit ?');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline" style="border-color:#dc3545; color:#dc3545;" title="Supprimer"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    {{ $products->withQueryString()->links() }}
@endsection
