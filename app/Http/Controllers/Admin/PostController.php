<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index()
    {
        $posts = Post::with(['category','user'])->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'content' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'required|in:Yes,No',
        ]);

        $validated['user_id'] = auth()->id();
        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success','Post created successfully.');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'content' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'required|in:Yes,No',
        ]);

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success','Post updated successfully.');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success','Post deleted successfully.');
    }
}


