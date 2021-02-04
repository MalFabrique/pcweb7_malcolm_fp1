@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-4">
            <h2>{{$user->name}}</h2>
            <p> {{$post->caption}}</p>

            <div class="pt-3"><a href="/post/{{ $post->id }}/edit">Edit Post</a></div>

            <form action="{{ route('post.destroy', $post) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" button style="margin: 10px; border-radius=10rem" type="submit">Delete Post</button>
                                </form>


        </div>
    </div>
</div>
@endsection