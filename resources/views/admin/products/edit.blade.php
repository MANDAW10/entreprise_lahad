@extends('layouts.admin')

@section('title', 'Modifier le produit')

@section('content')
    <h1>Modifier le produit</h1>
    <p><a href="{{ route('admin.products.index') }}">&larr; Liste</a></p>

    <form method="post" action="{{ route('admin.products.update', $product) }}" style="max-width: 500px;" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
            <label>Catégorie</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="form-group">
            <label>Prix (F)</label>
            <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="form-group">
            <label>Unité</label>
            <input type="text" name="unit" class="form-control" value="{{ old('unit', $product->unit) }}">
        </div>
        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', $product->stock) }}" required>
        </div>
        <div class="form-group">
            <label>Alerte stock</label>
            <input type="number" name="stock_alert" class="form-control" min="0" value="{{ old('stock_alert', $product->stock_alert) }}">
        </div>
        <div class="form-group">
            <label>Image</label>
            @if($product->image)
                <div style="margin-bottom: 0.5rem;">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Image" style="max-width: 150px; border-radius: var(--radius-sm);">
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
            <small style="color: var(--text-muted);">Laissez vide pour conserver l'image actuelle.</small>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}> Actif</label>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
@endsection
