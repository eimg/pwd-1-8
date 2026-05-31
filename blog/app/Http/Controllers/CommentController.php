<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function create(Request $request)
    {
        $request->validate([
            "article_id" => "required",
            "content" => "required",
        ]);

        $comment = new Comment;
        $comment->article_id = $request->article_id;
        $comment->content = $request->content;
        $comment->save();

        return back();
    }

    public function delete(string $id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return back();
    }
}
