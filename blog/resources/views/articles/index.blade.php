@extends("layouts.app")
@section("content")
    <div class="container" style="max-width: 800px">
        @foreach ($articles as $article)
            <div class="card mb-2">
                <div class="card-body">
                    <h3>{{ $article->title }}</h3>
                    <div class="text-muted">
                        {{ $article->created_at }}
                    </div>
                    <p>{{ $article->body }}</p>
                    <a href="{{ url("/articles/detail/$article->id") }}">View Detail</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
