<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'unit',
        'stock', 'stock_alert', 'image', 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getLowStockAttribute(): bool
    {
        return $this->stock > 0 && $this->stock <= $this->stock_alert;
    }

    public function getDisplayImageAttribute(): string
    {
        if ($this->image) {
            return str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image);
        }
        
        $name = strtolower($this->name);
        
        if (str_contains($name, 'poulet') || str_contains($name, 'chair')) {
            return 'https://images.unsplash.com/photo-1604503468506-a8da13d12791?auto=format&fit=crop&q=80&w=400';
        }
        if (str_contains($name, 'caille')) {
            return 'https://images.unsplash.com/photo-1516684732162-798a0062be99?auto=format&fit=crop&q=80&w=400';
        }
        if (str_contains($name, 'aliment') || str_contains($name, 'ponte') || str_contains($name, 'sac')) {
            return 'https://images.unsplash.com/photo-1586201375761-83865001e8ac?auto=format&fit=crop&q=80&w=400';
        }
        if (str_contains($name, 'agneau') || str_contains($name, 'mouton') || str_contains($name, 'viande')) {
            return 'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?auto=format&fit=crop&q=80&w=400';
        }
        if (str_contains($name, 'lait') || str_contains($name, 'yaourt') || str_contains($name, 'fromage')) {
            return 'https://images.unsplash.com/photo-1550583724-b2692b85b150?auto=format&fit=crop&q=80&w=400';
        }
        
        // Default generic agriculture fallback
        return 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=400';
    }
}
