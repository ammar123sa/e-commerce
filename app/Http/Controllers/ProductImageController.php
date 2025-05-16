<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Resources\ProductImageResource;

class ProductImageController extends Controller
{
    public function store(StoreProductImageRequest $request, Product $product)
    {
        $image = $product->images()->create($request->validated());
        return new ProductImageResource($image);
    }

    public function destroy(Product $product, $imageId)
    {
        $image = $product->images()->findOrFail($imageId);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
}
