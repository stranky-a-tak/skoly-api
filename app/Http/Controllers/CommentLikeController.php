<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Trait\Auth\AuthenticateUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentLikeController extends Controller
{
    use HasFactory, AuthenticateUser;

    public function create(Comment $comment)
    {
        if (!$this->authUser($comment->user_id)) {
            return $this->authUser($comment->user_id);
        }

        CommentLike::create([
            'comment_id' => $comment->id,
            'user_id' => $comment->id
        ]);

        return response()->json(['message' => 'success']);
    }

    public function destroy(Comment $comment)
    {
        if (!$this->authUser($comment->user_id)) {
            return $this->authUser($comment->user_id);
        }

        CommentLike::where(['comment_id' => $comment->id])->where(['user_id' => $comment->user_id])->delete();

        return response()->json(['message' => 'Success']);
    }
}
