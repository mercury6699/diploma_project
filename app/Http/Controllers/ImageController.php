<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $images = Image::all();
        return response()->json([
            'status' => 'success',
            'images' => $images,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        $image_path = $request->file('image')->store('images');


//        $ip = '127.0.0.1';
        $ip = '195.49.212.252';
        $url = $ip . ':8080/api/image/' . explode("/", $image_path)[1];
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
     * @param $file_name
     * @return \Illuminate\Http\Response
     * @throws FileNotFoundException
     */
    public function show($file_name): \Illuminate\Http\Response
    {
        $path = storage_path('app/images/' . $file_name);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);

        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;
    }
}
