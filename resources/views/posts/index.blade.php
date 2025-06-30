<h1>Posts</h1>
<a href="{{ route('posts.create') }}">Add Post</a>

<ul>
@foreach($posts as $post)
    <li>
        <strong>{{ $post->title }}</strong>
        <a href="{{ route('posts.edit', $post) }}">Edit</a>
        <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </li>
@endforeach
</ul>
