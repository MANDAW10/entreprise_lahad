@extends('layouts.admin')

@section('title', 'Nouvelle catégorie')

@section('content')
    <h1>Nouvelle catégorie</h1>
    <p><a href="{{ route('admin.categories.index') }}">&larr; Liste</a></p>

    <form method="post" action="{{ route('admin.categories.store') }}" style="max-width: 500px;">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label>Ordre d'affichage</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
@endsection
