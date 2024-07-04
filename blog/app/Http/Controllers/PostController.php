<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allposts=Post::all();

        return view('posts.index',['posts'=>$allposts ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user=User::all();
        return view('posts.create',['users'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'title'=>['required','min:3'],
            'description' =>['required','min:5'],
            'post_creator'=>['required','exists:users,id'],
        ]);

        $title=request()->title;
        $description=request()->description;

        $post=new Post();
        $post->title=$title;
        $post->description=$description;
        $post->user_id=request()->post_creator;
        $post->save();

        return to_route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $id)
    {

        return view('posts.show',['post'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $id)
    {
        $user=User::all();

        return  view('posts.edit',[ 'users'=>$user ,'post'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        request()->validate([
            'title'=>['required','min:3'],
            'description' =>['required','min:5'],
            'post_creator'=>['required','exists:users,id'],
        ]);

        $title=$request->title;
        $description=$request->description;

        $post=Post::findOrFail($id);
        $post->title=$title;
        $post->description=$description;
        $post->user_id=request()->post_creator;
        $post->save();

        return to_route('post.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
        $post->delete();
        return to_route('post.index');
    }
}
