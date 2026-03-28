@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('content')
    <h1>Modifier la catégorie</h1>
    <p><a href="{{ route('admin.categories.index') }}">&larr; Liste</a></p>

    <form method="post" action="{{ route('admin.categories.update', $category) }}" style="max-width: 500px;">
        @csrf
        @method('put')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="form-group">
            <label>Ordre d'affichage</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}> Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
@endsection
