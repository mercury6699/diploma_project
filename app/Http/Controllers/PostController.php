<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\PostHistory;
use App\Models\SubCategory;
use App\Models\Variable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response|JsonResponse
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            $SubCategory = SubCategory::find($post->sub_category_id);
            $Category = Category::find($SubCategory->category_id);
            $post->category_name = $Category->title;
            $post->sub_category_name = $SubCategory->title;
        }

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

        $post_id = $posts->id;
        PostHistory::create([
            'post_id' => $post_id,
            'variable_ids' => $variable_ids,
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'sub_category_id' => $sub_category_id,
            'created_by' => $id,
            'is_current' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully',
            'posts' => $posts,
        ]);
    }


    public function revert(Request $request): JsonResponse
    {


        $post_id = $request->input('post_id');
        $post_history_id = $request->input('post_history_id');

        $post_histories_current = PostHistory::where('post_id', $post_id)
            ->where('is_current', 1)
            ->get();

        foreach ($post_histories_current as $post_history) {
            $post_history->is_current = false;
            $post_history->save();
        }

        $PostHistory = PostHistory::find($post_history_id)->get();

        $post = Post::find($post_id);

        $post->title = $PostHistory->title;
        $post->description = $PostHistory->description;
        $post->content = $PostHistory->content;
        $post->sub_category_id = $PostHistory->sub_category_id;
        $post->variable_ids = $PostHistory->variable_ids;
        $post->updated_by = $PostHistory->created_by;

        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post reverted successfully',
            'posts' => $post,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param int $post_id
     * @return JsonResponse|Response
     */
    public function show(int $post_id): \Illuminate\Http\Response|JsonResponse
    {
        $posts = Post::find($post_id);

        $SubCategory = SubCategory::find($posts->sub_category_id);
        $Category = Category::find($SubCategory->category_id);
        $posts->category_name = $Category->title;
        $posts->sub_category_name = $SubCategory->title;

        $post_histories = PostHistory::where('post_id', $post_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'posts' => $posts,
            'post_histories' => $post_histories,
        ]);
    }

    public function show_history(int $post_history_id): \Illuminate\Http\Response|JsonResponse
    {
        $posts = PostHistory::find($post_history_id);

        return response()->json([
            'status' => 'success',
            'posts' => $posts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(Request $request, $post_id)
    {
        $post = Post::find($post_id);

        if (is_null($post)) {
            return response()->json([
                'status' => 'Failed',
                'message' => "Post with ID:{$post_id} not found",
                'post_id' => $post_id,
            ]);
        }

        $created_by = $post->created_by;
        $title = $request->input('title') ?? $post->title;
        $description = $request->input('description') ?? $post->description;
        $content = $request->input('content') ?? $post->content;
        $sub_category_id = $request->input('sub_category_id') ?? $post->sub_category_id;

        $variable_ids = $request->input('variable_ids');
        if (empty($variable_ids)) {
            $variable_ids = $post->variable_ids;
        } else {
            $variable_ids = json_encode($variable_ids);
        }

        $id = Auth::id();
        PostHistory::create([
            'post_id' => $post_id,
            'variable_ids' => $variable_ids,
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'sub_category_id' => $sub_category_id,
            'created_by' => $id,
        ]);

        $post->title = $title;
        $post->description = $description;
        $post->content = $content;
        $post->sub_category_id = $sub_category_id;
        $post->variable_ids = $variable_ids;
        $post->created_by = $created_by;
        $post->updated_by = $id;
        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully',
            'posts' => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy($post_id)
    {

        $post = Post::find($post_id);
        $post->delete();

        PostHistory::where('post_id', $post_id)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully',
            'posts' => $post,
        ]);
    }
}
