<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sub_categories = SubCategory::with('posts')->get();
        return response()->json([
            'status' => 'success',
            'sub_categories' => $sub_categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $id = Auth::id();
        $sub_category = SubCategory::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->get('content'),
            'category_id' => $request->category_id,
            'created_by' => $id,
            'updated_by' => $id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory created successfully',
            'sub_category' => $sub_category,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($sub_category_id)
    {
//        $sub_category = SubCategory::find($sub_category_id);
        $sub_category = SubCategory::with('posts')->find($sub_category_id);
        return response()->json([
            'status' => 'success',
            'sub_category' => $sub_category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $sub_category_id)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $id = Auth::id();
        $sub_category = SubCategory::find($sub_category_id);
        $sub_category->title = $request->title;
        $sub_category->description = $request->description;
        $sub_category->content = $request->get('content');
        $sub_category->category_id = $request->category_id;
        $sub_category->updated_by = $id;
        $sub_category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory updated successfully',
            'sub_category' => $sub_category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($sub_category_id)
    {
        $sub_category = SubCategory::find($sub_category_id);
        $sub_category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory deleted successfully',
            'sub_category' => $sub_category,
        ]);
    }
}
