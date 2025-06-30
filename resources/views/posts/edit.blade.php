<h1>Edit Post</h1>
<form method="POST" action="{{ route('posts.update', $post) }}">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $post->title }}" required>
    <textarea name="content">{{ $post->content }}</textarea>
    <button type="submit">Update</button>
</form>
