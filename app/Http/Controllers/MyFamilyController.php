<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Post;
use App\Models\MyFamily;
use Illuminate\Http\Request;

class MyFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $posts = \App\Models\Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $postscount = \App\Models\Post::where('user_id', $user->id)->count();

        return view('myFamily');

        // return view('profile', [
        //     'user' => $user,
        //     'profile' => $profile,
        //     'posts' => $posts,
        //     'postscount' => $postscount
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MyFamily  $myFamily
     * @return \Illuminate\Http\Response
     */
    public function show(MyFamily $myFamily)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MyFamily  $myFamily
     * @return \Illuminate\Http\Response
     */
    public function edit(MyFamily $myFamily)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MyFamily  $myFamily
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyFamily $myFamily)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyFamily  $myFamily
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyFamily $myFamily)
    {
        //
    }
}
