
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <form action="{{ route('profile.postCreate') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="description">Description</label>
                        <input class="form-control" type="text" name="description" id="description">
                    </div>

                    <div class="form-group row">
                        <label for="profilepic">Profile picture</label>
                        <input type="file" name="profilepic" id="profilepic">
                    </div>

                    <div class="form-group row">
                        <label for="nickname">Nickname</label>
                        <input class="form-control" type="text" name="nickname" id="nickname">
                    </div>

                    <div class="form-group row">
                        <label for="hobbies">Hobbies</label>
                        <input class="form-control" type="text" name="hobbies" id="hobbies">
                    </div>

                    <div class="form-group row">
                        <label for="dob">Birthdate</label>
                        <input class="form-control" type="date" name="dob" id="dob">
                    </div>

                    <div class="form-group row">
                        <label for="height">Height (in metres)</label>
                        <input class="form-control" type="text" name="height" id="height">
                    </div>

                    <div class="form-group row">
                        <label for="weight">Weight (in kg)</label>
                        <input class="form-control" type="text" name="weight" id="weight">
                    </div>

                    <div class="form-group row">
                        <label for="favquote">Your Favourite Quote</label>
                        <input class="form-control" type="text" name="favquote" id="favquote">
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">Create profile</button>
                    </div>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection
