<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:1024'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }
            
                $category = new Category();
                $category->title = $request->title;
                $category->description = $request->description;

                $category->save();


        return response()->json([
            'category' =>  new CategoryResource($category),
        ], 201);
    }

    public function index() {
        $allcategories = Category::all();
        return response()->json([
            'categories' => CategoryResource::collection($allcategories)
        ], 200);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'Message' => 'Invalid category id'
            ], 400);

            return response()->json([
                 'Category' => new CategoryResource($category)
            ], 200);
        }
    }

    public function update(Request $request, $id) {

        $category = Category::find($id);

        if (!$category){
            return response()->json(['invalid id'], 404);
        }else{
            $rules = [
                'title' => 'max:255',
                'description' => 'max:1024'
            ];
            
            $validator = Validator::make($request->all(), $rules);

                    if ($validator->fails()) {
                        return response()->json(['errors'=>$validator->errors()]);
                    }

                if ($request->has('title')) {
                    $category->title = $request->title;
                }

                if ($request->has('description')) {
                    $category->description = $request->description;
                }
                $category->save();

                return response()->json([
                    'message' => 'Category Updated',
                    'category' => new CategoryResource($category)
                ], 200);
        }
    }

    public function destroy($id) {

        $deleted = Category::find($id);

        if (!$deleted){
            return response()->json([
                'message' => 'please enter an valid id'
            ], 404);
        }else{

            $deleted->delete();

                return response()->json([
                    'message' => 'Category deleted!'
                ], 200);
        }
    }
}
