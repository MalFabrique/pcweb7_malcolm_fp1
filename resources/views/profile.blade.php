@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">

           <div class="container">
               <div class="row justify-content-center">
                   <div class="col-md-3">
                       <img class="rounded-circle" width="150" src="/storage/{{ $profile->image }}">
                   </div>
                   <div class="col-md-9">
                       <h3>{{ $user->name }}</h3>
                       <span><strong>{{ $postscount }}</strong> posts</span>

                        @if (empty($profile->description))
                        <div class="pt-3"><a href="/profile/edit">Add a description to your profile!</a></div>
                        @else:
                        <div class="pt-3"><h4>My Nickname</h4><div> 
                        <div class="pt-3">{{$profile->description}}</div>
                        
                        <div class="pt-3"><h4>Height</h4><div>
                        <div class="pt-3">{{$profile->height}} m</div>
                        <div class="pt-3"><h4>Weight</h4><div>
                        <div class="pt-3">{{$profile->weight}} kg</div>
                        <div class="pt-3"><h4>Favourite Hobbies</h4><div>
                        <div class="pt-3">{{$profile->hobbies}}</div>
                        <div class="pt-3"><h4>Favourite Quote</h4><div>
                        <div class="pt-3">{{$profile->favquote}}</div>
                        <div class="pt-3"><h4>My Birthday's coming!</h4><div>
                        <div class="pt-3">{{$profile->dob}}</div>
                        <div class="pt-3"><a href="/profile/edit">Edit profile</a></div>
                        @endif

                   </div>

<div class="row pt-5">
        @foreach($posts as $post)
            <div class="col-4 mb-5">
            <h6>{{$post->updated_at}}</h6>
                <a href="/post/{{$post->id}}">
                    <img src="/storage/{{$post->image}}" class="w-100">
                    <p> {{$post->caption}}</p>
                </a>
            </div>
        @endforeach
    </div>
</div>


               </div>
               </div>
           </div>

       </div>
   </div>
</div>
@endsection

