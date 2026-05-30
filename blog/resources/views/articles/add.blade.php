@extends("layouts.app")

@section("content")
    <div class="container" style="max-width: 600px">

        @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $err)
                    {{ $err }}
                @endforeach
            </div>
        @endif

        <form action="{{ url("/articles/create") }}" method="post">
            @csrf

            <input type="text" class="form-control mb-2" name="title" placeholder="Title">
            <textarea name="body" class="form-control mb-2" placeholder="Body"></textarea>
            <select name="category_id" class="form-select mb-2">
                <option value="1">News</option>
                <option value="2">Tech</option>
            </select>
            <button class="btn btn-primary">Add Article</button>
        </form>
    </div>
@endsection
