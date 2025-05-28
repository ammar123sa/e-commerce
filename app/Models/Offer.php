<?php

// app/Models/Offer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'new_price',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->with('images');
    }

    public function getTimeLeftAttribute()
    {
        if (!$this->ends_at || $this->ends_at->isPast()) {
            return 'Expired';
        }

        $diff = now()->diff($this->ends_at);
        return "{$diff->d}d {$diff->h}h {$diff->i}m";
    }
}

