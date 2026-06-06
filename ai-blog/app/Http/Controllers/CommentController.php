<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $request->user()->comments()->create([
            'content' => $validated['content'],
            'post_id' => $post->id,
        ]);

        return redirect()->route('posts.show', $post)->with('status', 'Comment added successfully.');
    }

    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $comment->update($validated);

        return redirect()->route('posts.show', $comment->post)->with('status', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $post = $comment->post;
        $comment->delete();

        return redirect()->route('posts.show', $post)->with('status', 'Comment deleted successfully.');
    }
}
