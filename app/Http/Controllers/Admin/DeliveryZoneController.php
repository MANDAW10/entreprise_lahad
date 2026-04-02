<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;

class DeliveryZoneController extends Controller
{
    public function index()
    {
        $zones = DeliveryZone::all();
        return view('admin.delivery_zones.index', compact('zones'));
    }

    public function create()
    {
        return view('admin.delivery_zones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:delivery_zones,name',
            'fee' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->only('name', 'fee');
        $data['is_active'] = $request->boolean('is_active');
        DeliveryZone::create($data);

        return redirect()->route('admin.delivery_zones.index')->with('success', 'Zone de livraison créée.');
    }

    public function edit(DeliveryZone $deliveryZone)
    {
        return view('admin.delivery_zones.edit', compact('deliveryZone'));
    }

    public function update(Request $request, DeliveryZone $deliveryZone)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:delivery_zones,name,' . $deliveryZone->id,
            'fee' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->only('name', 'fee');
        $data['is_active'] = $request->boolean('is_active');
        $deliveryZone->update($data);

        return redirect()->route('admin.delivery_zones.index')->with('success', 'Zone de livraison mise à jour.');
    }

    public function destroy(DeliveryZone $deliveryZone)
    {
        // Optionnel : vérifier s'il a des commandes liées avant de supprimer
        if (\App\Models\Order::where('delivery_zone_id', $deliveryZone->id)->exists()) {
            return back()->with('error', 'Impossible de supprimer cette zone, des commandes y sont rattachées.');
        }

        $deliveryZone->delete();
        return redirect()->route('admin.delivery_zones.index')->with('success', 'Zone de livraison supprimée.');
    }
}
