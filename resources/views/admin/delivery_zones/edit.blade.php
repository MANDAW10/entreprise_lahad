@extends('layouts.admin')

@section('title', 'Modifier la Zone de Livraison')

@section('content')
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.delivery_zones.index') }}" class="btn btn-outline" style="padding: 0.5rem 1rem;"><i class="fas fa-arrow-left"></i> Retour</a>
        <h1 style="margin: 0;">Modifier la Zone : {{ $deliveryZone->name }}</h1>
    </div>

    <form action="{{ route('admin.delivery_zones.update', $deliveryZone) }}" method="post" style="max-width: 600px; background: rgba(255, 255, 255, 0.9); border-radius: 16px; padding: 2rem; box-shadow: 0 8px 30px rgba(0,0,0,0.04); backdrop-filter: blur(10px);">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Nom de la destination (ex: Dakar, Pikine, Rufisque...)</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $deliveryZone->name) }}" required>
            @error('name') <div class="invalid-feedback" style="color:#dc3545; font-size:0.85rem; margin-top:0.25rem;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group" style="margin-top: 1.5rem;">
            <label>Frais de livraison (CFA)</label>
            <input type="number" name="fee" class="form-control @error('fee') is-invalid @enderror" value="{{ old('fee', $deliveryZone->fee) }}" min="0" step="1" required>
            @error('fee') <div class="invalid-feedback" style="color:#dc3545; font-size:0.85rem; margin-top:0.25rem;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group" style="margin-top: 1.5rem;">
            <label style="display:flex; align-items:center; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $deliveryZone->is_active) ? 'checked' : '' }} style="margin-right:0.75rem; width:18px; height:18px;">
                <span style="font-weight: 500;">Zone active (visible lors de la commande)</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="margin-top: 2rem; padding: 1rem; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 8px 20px rgba(232, 93, 4, 0.25);">Mettre à jour la zone</button>
    </form>
@endsection
