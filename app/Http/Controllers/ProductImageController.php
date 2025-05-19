<?php
namespace App\Http\Controllers;

use App\Models\Product;

use App\Http\Requests\StoreProductImageRequest;
use App\Http\Resources\ProductImageResource;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(StoreProductImageRequest $request, Product $product)
    {
        $file = $request->file('image');
        $path = $file->store('product_images', 'public');

        $image = $product->images()->create([
            'image_url' => Storage::url($path),
        ]);

        return new ProductImageResource($image);
    }

    public function destroy(Product $product, $imageId)
    {
        $image = $product->images()->findOrFail($imageId);
        $filePath = str_replace('/storage/', '', $image->image_url);
        Storage::disk('public')->delete($filePath);

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
}
