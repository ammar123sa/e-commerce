<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OfferController extends Controller
{
    public function store(StoreOfferRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        $offer = Offer::create([
            'product_id' => $product->id,
            'new_price' => $request->new_price,
            'starts_at' => now(),
            'ends_at' => now()->addDays($request->duration),
        ]);
         $offer->product()->update(['has_offer' => true]);

        return new OfferResource($offer->load('product'));
    }

    public function index()
    {
        $offers = Offer::with(['product.images'])
        ->where('ends_at', '>', now())
        ->get();

    return OfferResource::collection($offers);
    }

    public function show($id)
    {
        $offer = Offer::with('product')->findOrFail($id);
        
        return new OfferResource($offer);
    }
    public function destroy($id)
{
    $offer = Offer::findOrFail($id);
    $offer->delete();

    return response()->json(['message' => 'Offer deleted successfully.']);
}
}
