<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        Post::create($request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]));
        return redirect()->route('posts.index');    
    }

    public function edit(Post $post) {
        return view('posts.edit', compact('post'));
    }

    public function show($id) {
        return Post::findOrFail($id);
    }

    public function update(Request $request, Post $post) {
        $post->update($request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]));
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post) {
        $post->delete();
        return back();
    }
}
