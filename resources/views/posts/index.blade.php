@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Add Post</a>
    </div>

    <ul class="list-group">
        @foreach($posts as $post)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <strong class="d-block mb-2">{{ $post->title }}</strong>
                    <p class="text-muted mb-2">{{ Str::limit($post->content, 150) }}</p>
                    <div class="small text-secondary">
                        <span class="me-3">
                            <i class="bi bi-person me-1"></i>
                            By: <strong>{{ $post->user->name }}</strong>
                        </span>
                        <span class="me-3">
                            <i class="bi bi-calendar-plus me-1"></i>
                            Created: <span class="local-time" data-utc="{{ $post->created_at->toISOString() }}">{{ $post->created_at->format('M j, Y g:i A') }}</span>
                        </span>
                        @if($post->created_at != $post->updated_at)
                            <span>
                                <i class="bi bi-pencil me-1"></i>
                                Edited: <span class="local-time" data-utc="{{ $post->updated_at->toISOString() }}">{{ $post->updated_at->format('M j, Y g:i A') }}</span>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="ms-3">
                    @if(auth()->check() && auth()->user()->id === $post->user_id)
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this post?')">Delete</button>
                        </form>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Convert all timestamps to user's local timezone
    const timeElements = document.querySelectorAll('.local-time');
    
    timeElements.forEach(function(element) {
        const utcTime = element.getAttribute('data-utc');
        const localDate = new Date(utcTime);
        
        // Format the date in user's local timezone
        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        };
        
        const localTimeString = localDate.toLocaleString('en-US', options);
        element.textContent = localTimeString;
    });
});
</script>
@endsection