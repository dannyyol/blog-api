<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $posts = Post::latest()->get();
        return response()->json(PostResource::collection($posts), 200);
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

        if (!\Gate::allows('isAdmin')) {
            return response()->json(['status'=>'error', "message" => "Sorry! you are not an admin, you can not perform this action"], 405);

        }
        $this->validate($request, [
            'topic' => 'required',
            'body' => 'required|max:255',
            'category_id' => 'required|numeric'
        ]);

        try{
            $post = Post::create([
                'topic' => $request['topic'],
                'body' => $request['body'],
                'category_id' => $request->category_id,
            ]);

            return response()->json(['status'=>'success', "message" => 'The post ' . $post->topic . ' was created successfully', 'data' => new PostResource($post)], 200);
        }
        catch(QueryException $err){
            return response()->json(['status'=>'error', "message" => "Post could not be created"], 404);
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
        try{
            $post= Post::findOrFail($id);

            return response()->json(['status'=>'success', 'data' => new PostResource($post)], 200);
        }
        catch(ModelNotFoundException $err){
            return response()->json(['status'=>'error', "message" => "The requested post was not found"], 404);
        }
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
        if (!\Gate::allows('isAdmin')) {
            return response()->json(['status'=>'error', "message" => "Sorry! you are not an admin, you can not perform this action"], 405);
        }

        $this->validate($request, [
            'topic' => 'required',
            'body' => 'required|max:255',
            'category_id' => 'required|numeric',
        ]);
        try{
            $post= Post::findOrFail($id);

            $post->update([
                'topic'=>$request->get('topic'),
                'body'=> $request->get('body'),
                'category_id' => $request->get('category_id'),
            ]);

            return response()->json(['status'=>'success', "message" => 'The post ' . $post->topic . ' was updated successfully', 'data' => new PostResource($post)], 200);
        }
        catch(ModelNotFoundException $err){
            return response()->json(['status'=>'error', "message" => "The requested post was not found"], 404);
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
        if (!\Gate::allows('isAdmin')) {
            return response()->json(['status'=>'error', "message" => "Sorry! you are not an admin, you can not perform this action"], 405);
        }

        try{
            $post= Post::findOrFail($id);
            $post->delete();
            return response()->json(['status'=>'success', "message" => 'The post was deleted successfully'], 204);
        }
        catch(ModelNotFoundException $err){
            return response()->json(['status'=>'error', "message" => "The requested post was not found"], 404);
        }
    }
}
