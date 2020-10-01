<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category = Category::all();
        return response()->json(CategoryResource::collection($category), 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
        ]);

        try{
            $category = Category::create([
                'name' => $request['name']
            ]);
            return response()->json(['status'=>'success', "message" => 'The category ' . $category->name . ' was created successfully', 'data' => new CategoryResource($category)], 200);
        }
        catch(QueryException $err){
            return response()->json(['status'=>'error', "message" => "Category could not be created"], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required',
        ]);
        try{
            $category= Category::findOrFail($id);

            $category->update([
                'name'=>$request->get('name')
            ]);

            return response()->json(['status'=>'success', "message" => 'The category ' . $category->name . ' was updated successfully', 'data' => new CategoryResource($category)], 200);
        }
        catch(ModelNotFoundException $err){
            return response()->json(['status'=>'error', "message" => "The requested post category was not found"], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            $category= Category::findOrFail($id);
            $category->delete();
            return response()->json(['status'=>'success', "message" => 'The category was deleted successfully'], 204);
        }
        catch(ModelNotFoundException $err){
            return response()->json(['status'=>'error', "message" => "The requested category was not found"], 404);
        }
    }
}
