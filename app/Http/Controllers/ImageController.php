<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $images = Image::all();
        return response()->json([
            'status' => 'success',
            'images' => $images,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $image_path = $request->file('image')->store('images');


//        $ip = '127.0.0.1';
        $ip = '195.49.212.252';
        $url = $ip . '/api/image/' . explode("/", $image_path)[1];
        $images = Image::create([
            'path' => $image_path,
            'url' => $url,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Image created successfully',
            'images' => $images,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function show($file_name)
    {
//        dd($file_name);
        $path = storage_path('app/images/' . $file_name);

        if (!\Illuminate\Support\Facades\File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);

        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
