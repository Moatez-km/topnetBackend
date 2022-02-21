<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {   $posts=[
        'mon super premier titre',
        'mon super second titre'
    ];
        //$title= 'mon super premier titre';
       // $title2= 'mon super second titre';
        return view('articles',compact('posts'));
         // return view('articles')->with('title',$title);
    }
   // public function show($id)
    //{
      //  $posts =[
       //     1=>'mon titre n°1',
       //     2=>'mon titre n°2'
      //  ];
      //  $post= $posts[$id] ?? 'pas de titre';
       // return view('article',[
       //     'post'=>$post
      //  ]);


    //}
    public function show($slug)
    {
        return view('post', [
            'post' => Post::where('slug', '=', $slug)->first()
        ]);
    }
    public function store(Request $request)
   {
       $post = new Post;

       $post->title = $request->title;
       $post->body = $request->body;
       $post->slug = $request->slug;

       $post->save();

       return response()->json(["result" => "ok"], 201);
   }
   public function destroy($postId)
    {
        $post = Post::find($postId);
        $post->delete();

        return response()->json(["result" => "Delete post successfully !"], 200);
     }
 public function update(Request $request, $postId)
    {
        $post = Post::find($postId);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->slug = $request->slug;
        $post->save();

        return response()->json(["result" => "Post upadated ."], 201);
    }

    public function contact()
    {
        return view('contact');
    }
}
