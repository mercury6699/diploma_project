<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Command\ListCommand\VariableEnumerator;

//use Illuminate\Http\Request;

class VariableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $variables = Variable::all();
        return response()->json([
            'status' => 'success',
            'vars' => $variables,
        ]);
    }

    public function variables_by_ids(Request $request): \Illuminate\Http\JsonResponse
    {
        $ids = $request->input('ids');

        $vars = Variable::findMany($ids);

        if ($vars->isEmpty()) {
            $vars = [];
        }

        return response()->json([
            'status' => 'success',
            'vars' => $vars,
        ]);
    }

    public function store(Request $request)
    {

        $id = Auth::id();

        $name = $request->name;
        $value = $request->value;
        $category_id = $request->category_id;
        $sub_category_id = $request->sub_category_id;

        $vars = Variable::create([
            'name' => $name,
            'value' => $value,
            'category_id' => $category_id,
            'sub_category_id' => $sub_category_id,
            'created_by' => $id,
            'updated_by' => $id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Variable created successfully',
            'vars' => $vars,
        ]);
    }

    public function show($variable_id): \Illuminate\Http\JsonResponse
    {
        $vars = Variable::find($variable_id);
        if (is_null($vars)) {
            $vars = [];
        }

        return response()->json([
            'status' => 'success',
            'vars' => $vars,
        ]);
    }

    public function update($variable_id, Request $request)
    {
        $vars = Variable::find($variable_id);

        if (is_null($vars)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Variable is not found',
//                'vars' => $vars,
            ]);
        }

        $id = Auth::id();

        $name = $request->name;
        $value = $request->value;

        $vars->name = $name;
        $vars->value = $value;
        $vars->updated_by = $id;
        $vars->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Variable updated successfully',
            'vars' => $vars,
        ]);
    }

    public function destroy($variable_id)
    {
        $vars = Variable::find($variable_id);
        $vars->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Variable deleted successfully',
            'vars' => $vars,
        ]);
    }
}
