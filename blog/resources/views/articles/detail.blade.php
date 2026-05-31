@extends("layouts.app")

@section("content")
    <div class="container" style="max-width: 800px">
        <div class="card mb-2 border-primary">
            <div class="card-body">
                <h3>{{ $article->title }}</h3>
                <div class="text-muted">
                    <b class="text-success">
                        {{ $article->user->name }},
                    </b>,
                    <b>Category:</b> {{ $article->category->name }},
                    <b>Comments:</b> {{ count($article->comments) }},
                    {{ $article->created_at }}
                </div>
                <p>
                    {{ $article->body }}
                </p>
                <a href="{{ url("/articles/delete/$article->id") }}"
                    class="btn btn-sm btn-outline-danger">Delete</a>
            </div>
        </div>

        <ul class="list-group mt-4">
            <li class="list-group-item active">
                Comments ({{ count($article->comments) }})
            </li>
            @foreach ($article->comments as $comment)
                <li class="list-group-item">
                    <a href="{{ url("/comments/delete/$comment->id") }}"
                        class="btn-close float-end"></a>
                    
                    <b class="text-success">
                        {{ $comment->user->name }}
                    </b> - 
                    {{ $comment->content }}
                </li>
            @endforeach
        </ul>
        <form action="{{ url("/comments/create") }}" method="post" class="mt-2">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <textarea class="form-control mb-2" name="content"></textarea>
            <button class="btn btn-secondary">Add Comment</button>
        </form>
    </div>
@endsection