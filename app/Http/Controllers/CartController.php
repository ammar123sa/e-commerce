<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
{
    $cart = Auth::user()->cart()
        ->with('items.product.images') 
        ->firstOrCreate();

    return new CartResource($cart);
}

    public function store(StoreCartItemRequest $request)
    {
        $cart = Auth::user()->cart()->firstOrCreate();

        $item = $cart->items()->updateOrCreate(
            
            ['product_id' => $request->product_id],
            ['quantity' => DB::raw("quantity + {$request->quantity}")]
        );

        return response()->json(['message' => 'Item added to cart']);
    }

    public function update(UpdateCartItemRequest $request, CartItem $item)
    {
       

        $item->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Quantity updated']);
    }

    public function destroy(CartItem $item)
    {
        

        $item->delete();

        return response()->json(['message' => 'Item removed']);
    }
}
