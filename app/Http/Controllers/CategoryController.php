<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
//        var_dump(Auth::id());
//        die();
//        $categories = Category::with(['sub_categories', 'posts'])
        $categories = Category::with(['posts'])
            ->get();
//        $categories = Category::all();
        return response()->json([
            'status' => 'success',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
        ]);

//        $id = auth()->user()->id;
        $id = Auth::id();
//        dd($id);
        $category = Category::with(['posts'])
            ->create([
                'title' => $request->title,
                'description' => $request->description,
                'created_by' => $id,
                'updated_by' => $id,
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'category' => $category,
        ]);
//        return response()->json([]);
    }

    public function show($category_id)
    {
        $category = Category::with(['posts'])
            ->find($category_id);
        return response()->json([
            'status' => 'success',
            'category' => $category,
        ]);
    }

    public function update($category_id, Request $request)
    {
//        dd(file_get_contents('php://input'), $_POST);
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
        ]);

//        var_dump(file_get_contents('php://input'));
//        var_dump($request);
//        var_dump($request->get('title'));
//        var_dump($request->description);
//        var_dump(Auth::id());
//        die();
        $category = Category::with(['posts'])
            ->find($category_id);
        $category->title = $request->title;
        $category->description = $request->description;
        $category->updated_by = Auth::id();
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'category' => $category,
        ]);
    }

    public function destroy($category_id)
    {
        $category = Category::with(['posts'])
            ->find($category_id);
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully',
            'category' => $category,
        ]);
    }

}
