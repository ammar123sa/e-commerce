<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Http\Requests\StoreRatingRequest;
use App\Http\Resources\RatingResource;
use App\Http\Resources\UserResource;
use App\Models\Rating;
class RatingController extends Controller
{
    public function store(StoreRatingRequest $request)
{
    $rating = Rating::updateOrCreate(
        ['user_id' => auth()->id(), 'product_id' => $request->product_id],
        ['rating' => $request->rating]
    );

    return new RatingResource($rating);
}

}
