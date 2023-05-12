<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use App\Models\Variable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response|JsonResponse
    {
        $posts = Post::all();
        return response()->json([
            'status' => 'success',
            'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        $title = $request->input('title');
        $description = $request->input('description');
        $content = $request->input('content');
        $sub_category_id = $request->input('sub_category_id');
        $variable_ids = $request->input('variable_ids');
        $variable_ids = json_encode($variable_ids);



//        $validatedData = $request->validated();
//        $validatedData['user_id'] = $request->user()->id;
//        $blogPost = BlogPost::create($validatedData);
//
//
//        if ($request->hasFile('thumbnail'))
//        {
//            $path = $request->file('thumbnail')->store('thumbnails');
//            $blogPost->image()->save( Image::make(['path' => $path]) );
//        }

        $id = Auth::id();
        $posts = Post::create([
            'variable_ids' => $variable_ids,
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'sub_category_id' => $sub_category_id,
            'created_by' => $id,
            'updated_by' => $id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully',
            'posts' => $posts,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function show($post_id)
    {
        $posts = Post::find($post_id);

//        dd($post_id,'post');
        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully',
            'posts' => $posts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
