<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
    }


    public function addPostComment(Request $request, Post $post)
     {
        if (!\Auth::check()) {
            return response()->json(['status'=>'error', "message" => "Sorry! you are not a user, you can not perform this action"], 405);
        }
        $this->validate($request,[
            'fullname' =>'required',
            'body'=>'required',
            'email' => 'required'
        ]);
        try{
            $form=new Comment();
            $form->user_id=auth()->user()->id;
            $form->fullname = $request->fullname;
            $form->body = $request->body;
            $form->email=$request->email;
            $post->comments()->save($form);
            if($form->save()){
                return response()->json(['status'=>'success', "message" => 'The  comment was created successfully', 'data' => new CommentResource($form)], 200);
            }

        }
        catch(QueryException $err){
            // dd($err->getMessage());
            return response()->json(['status'=>'error', "message" => "Comment could not be created"], 404);
        }

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
    public function update(Request $request, Comment $comment)
    {

        if (\Auth::user()->id == $comment->user_id || \Gate::allows('isAdmin')) {
            $comment->update($request->all());
            return response()->json(['status'=>'success', "message" => 'The comment  was updated successfully', 'data' => new CommentResource($comment)], 200);
        } else{
            return response()->json(['status'=>'success', "message" => 'You are not authorize to perform this action'], 405);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
        if (\Auth::user()->id == $comment->user_id || \Gate::allows('isAdmin')) {
            try {
                $comment= Comment::findOrFail($comment->id);
                $delete_comment = $comment->delete();
                return response()->json(['status'=>'success', "message" => 'The comment was deleted successfully', 'data' => $delete_comment], 204);
            } catch (ModelNotFoundException $err) {
                return response()->json(['status'=>'error', "message" => "The requested comment was not found"], 404);
            }
        }else{
            return response()->json(['status'=>'success', "message" => 'You are not authorize to perform this action'], 405);
        }
    }
}
