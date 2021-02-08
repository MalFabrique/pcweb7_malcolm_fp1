
@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">

           <div class="container">
               <div class="row justify-content-center">
                   <div class="col-md-3">

@if (!empty($profile->description))

<div class="pt-3">{{$profile->description}}</div>
<img class="rounded-circle" width="150" src="/storage/{{ $profile->image }}">
@else:
 
@endif


                   @foreach($users as $user)
                       <h3>{{ $user->name }}  <a href="/profile/{{$user->id}}">View Posts</a> </h3>
                       {{-- <div class="pt-3">{{$profile->description}}</div>
                       <img class="rounded-circle" width="150" src="/storage/{{ $profile->image }}"> --}}
                        
                   @endforeach
                    <div>
                <div>
            </div>
        </div>


    </div>
</div>

@endsection