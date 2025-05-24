<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'price',
        'description',
        'attributes',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'attributes' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function favoredBy()
{
    return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
}

}
