<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest ;
use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Events\NewCommentEvent ;
class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
{
    $comment = Comment::create([
        'user_id' => auth()->id(),
        'product_id' => $request->product_id,
        'comment' => $request->comment,
    ]);

    // بث الحدث عبر Pusher
    broadcast(new NewCommentEvent($comment))->toOthers();

    return new CommentResource($comment);
}

}
