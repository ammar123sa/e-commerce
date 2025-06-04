<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Events\NewCommentEvent;

class CommentController extends Controller
{
    public function index($productId)
    {
        $comments = Comment::where('product_id', $productId)
            ->with('user')
            ->latest()
            ->get();

        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'comment' => $request->comment,
        ]);

        $comment->load('user');
        broadcast(new NewCommentEvent($comment))->toOthers();

        return new CommentResource($comment);
    }

    public function update(UpdateCommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'you can\'t edit this comment'], 403);
        }

        $comment->update([
            'comment' => $request->comment,
        ]);

        return new CommentResource($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'you can\'t delete '], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'you delete this comment']);
    }
}
