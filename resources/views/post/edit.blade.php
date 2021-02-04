
@extends('layouts.app')
@section('content')
   <div class="container">
       <div class="row">
           <div class="col-4"></div>
           <div class="col-4">
               <form action="{{ route('post.update', $post->id)}}" enctype="multipart/form-data" method="post">
                   @csrf
                   @if ($post == null)
                       <div>No post added yet!</div>
                   @endif
                   <div class="form-group row">
                       <label for="caption">Caption</label>
                       <input class="form-control" type="text" name="caption" id="caption"
                           value="{{ $post->caption }}">
                   </div>
                   <div>
                       <label for="postpic">Picture Post</label>
                       <br>
                       <input type="file" name="postpic" id="postpic"
                       img src="/storage/{{$post->image}}">
                   </div>
                   <div class="row">
                   <p></p>
                       <button type="submit" class="btn btn-primary" style="margin: 20px" >Submit Updates</button>
                   </div>
               </form>
           </div>
           <div class="col-4"></div>
       </div>
   </div>
@endsection