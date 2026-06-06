<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['user', 'category'])
            ->latest()
            ->paginate(9);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        $this->authorize('create', Post::class);

        $categories = Category::orderBy('name')->get();

        return view('posts.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'feature_image' => ['required', 'url', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $post = $request->user()->posts()->create($validated);

        return redirect()->route('posts.show', $post)->with('status', 'Post created successfully.');
    }

    public function show(Post $post): View
    {
        $this->authorize('view', $post);

        $post->load(['user', 'category', 'comments.user']);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        $categories = Category::orderBy('name')->get();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'feature_image' => ['required', 'url', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post deleted successfully.');
    }
}
