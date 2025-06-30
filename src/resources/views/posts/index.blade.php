@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">All Posts</h1>
        <a href="{{ route('posts.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Create New Post
        </a>
    </div>

    <div class="space-y-4">
        @forelse($posts as $post)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-3">{{ $post->title }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $post->content }}</p>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('posts.edit', $post) }}" 
                           class="inline-flex items-center px-3 py-1.5 bg-yellow-500 border border-transparent rounded text-xs font-medium text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit
                        </a>
                        
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Delete this post?')"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded text-xs font-medium text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <p>No posts found. <a href="{{ route('posts.create') }}" class="text-blue-600 dark:text-blue-400 underline">Create your first post!</a></p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection