@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Add Post</a>
    </div>

    <ul class="list-group">
        @foreach($posts as $post)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>{{ $post->title }}</strong>
                <div>
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this post?')">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
