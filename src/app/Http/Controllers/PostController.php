<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        return Post::all();
    }

    public function store(Request $request) {
        return Post::create($request->only(['title', 'content']));
    }

    public function show($id) {
        return Post::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $post = Post::findOrFail($id);
        $post->update($request->only(['title', 'content']));
        return $post;
    }

    public function destroy($id) {
        Post::destroy($id);
        return response()->noContent();
    }
}
