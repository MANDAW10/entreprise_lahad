@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
    <h1>Catégories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Nouvelle catégorie</a>

    <div class="table-responsive">
        <table class="table" style="margin-top: 1rem;">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Slug</th>
                <th>Produits</th>
                <th>Ordre</th>
                <th>Actif</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->slug }}</td>
                    <td>{{ $c->products_count }}</td>
                    <td>{{ $c->sort_order }}</td>
                    <td>{{ $c->is_active ? 'Oui' : 'Non' }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-sm btn-outline" title="Modifier"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.categories.destroy', $c) }}" method="post" style="display:inline;" onsubmit="return confirm('Supprimer cette catégorie ?');">
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
@endsection
