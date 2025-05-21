<?php
namespace App\Http\Controllers;

use App\Models\Product;

use App\Http\Requests\StoreProductImageRequest;
use App\Http\Resources\ProductImageResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductImageController extends Controller
{


public function store(StoreProductImageRequest $request, Product $product)
{
    $file = $request->file('image');
    $imageData = base64_encode(file_get_contents($file));
    
    $response = Http::asForm()->post('https://api.imgbb.com/1/upload', [
        'key' => env('IMGBB_API_KEY'),
        'image' => $imageData,
    ]);

    if (!$response->successful()) {
        return response()->json(['message' => 'Failed to upload image to ImgBB'], 500);
    }

    $imgUrl = $response->json('data.url');

    $image = $product->images()->create([
        'image_url' => $imgUrl,
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
