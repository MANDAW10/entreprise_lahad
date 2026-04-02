@extends('layouts.admin')

@section('title', 'Zones de Livraison')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0;">Zones de Livraison</h1>
        <a href="{{ route('admin.delivery_zones.create') }}" class="btn btn-primary" style="box-shadow: 0 8px 20px rgba(232, 93, 4, 0.25);">Nouvelle Zone</a>
    </div>

    <div class="table-responsive" style="background: rgba(255, 255, 255, 0.9); border-radius: 16px; padding: 1.5rem; box-shadow: 0 8px 30px rgba(0,0,0,0.04); backdrop-filter: blur(10px);">
        <table class="table">
        <thead>
            <tr>
                <th>Nom de la zone</th>
                <th>Frais de livraison (CFA)</th>
                <th>Statut</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($zones as $z)
                <tr>
                    <td style="font-weight: 600;">{{ $z->name }}</td>
                    <td style="color: var(--primary-dark); font-weight: 700;">{{ number_format($z->fee, 0, ',', ' ') }} CFA</td>
                    <td>
                        @if($z->is_active)
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Actif</span>
                        @else
                            <span style="background: #fee2e2; color: #dc2626; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Inactif</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('admin.delivery_zones.edit', $z) }}" class="btn btn-sm btn-outline" title="Modifier" style="margin-right: 0.5rem;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.delivery_zones.destroy', $z) }}" method="post" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline" style="border-color:#dc3545; color:#dc3545;" title="Supprimer"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        <i class="fas fa-map-marked-alt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3; display: block;"></i>
                        Aucune zone de livraison définie.<br>
                        <a href="{{ route('admin.delivery_zones.create') }}" style="color: var(--primary); font-weight: 600; text-decoration: none; margin-top: 0.5rem; display: inline-block;">Créer votre première zone</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
        </table>
    </div>
@endsection
