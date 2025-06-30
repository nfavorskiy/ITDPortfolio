<h1>Create Post</h1>
<form method="POST" action="{{ route('posts.store') }}">
    @csrf
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="content" placeholder="Content"></textarea>
    <button type="submit">Save</button>
</form>
