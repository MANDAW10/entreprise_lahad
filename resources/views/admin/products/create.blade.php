@extends('layouts.admin')

@section('title', 'Nouveau produit')

@section('content')
    <h1>Nouveau produit</h1>
    <p><a href="{{ route('admin.products.index') }}">&larr; Liste</a></p>

    <form method="post" action="{{ route('admin.products.store') }}" style="max-width: 500px;" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Catégorie</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label>Prix (F)</label>
            <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" required>
        </div>
        <div class="form-group">
            <label>Unité</label>
            <input type="text" name="unit" class="form-control" value="{{ old('unit', 'kg') }}" placeholder="kg, L, pièce, sac...">
        </div>
        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', 0) }}" required>
        </div>
        <div class="form-group">
            <label>Alerte stock (seuil)</label>
            <input type="number" name="stock_alert" class="form-control" min="0" value="{{ old('stock_alert', 5) }}">
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> Actif</label>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
@endsection
