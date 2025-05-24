<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FavoriteResource;
class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()
        ->favorites()
        ->with('images') 
        ->get();
       
        return FavoriteResource::collection($favorites);
    }

    public function store(Product $product)
    {
        $user = Auth::user();
        if (!$user->favorites->contains($product->id)) {
            $user->favorites()->attach($product->id);
        }

        return response()->json(['message' => 'Product added to favorites']);
    }

    public function destroy(Product $product)
    {
        Auth::user()->favorites()->detach($product->id);

        return response()->json(['message' => 'Product removed from favorites']);
    }
}
