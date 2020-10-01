<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth:api');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return response()->json(['status'=>'success', 'data' => $users], 200);
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

        if (!\Gate::allows('isAdmin')) {
            return response()->json(['status'=>'error', "message" => "Sorry! you are not an admin, you can not perform this action"], 405);

        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>'error', 'data' => $validator->errors()->all()], 422);
        }

        $plainPassword=$request->password;
        $password=bcrypt($request->password);
        $request->request->add(['password' => $password]);

        // create the user account
        $created=User::create($request->all());
        $request->request->add(['password' => $plainPassword]);
        return response()->json(['status'=>'success', 'message' => "User with the name $created->name was created successfully"], 200);

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
        if (!\Gate::allows('isAdmin') || !\Gate::allows('isAuthor')) {
            return response()->json(['status'=>'error', "message" => "Sorry! you are not an admin, you can not perform this action"], 405);
        }

        $user =  auth('api')->user();
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);

        try{
            $user->update([
                'name'=>$request->get('name'),
                'email'=> $request->get('email'),
                'password' => Hash::make($request['password'])
            ]);

            return response()->json(['status'=>'success', "message" => 'The user with the name ' . $user->name . ' was updated successfully', 'data' => $user], 200);
        }
        catch(QueryException $err){
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
            $post= User::findOrFail($id);
            $post->delete();
            return response()->json(['status'=>'success', "message" => 'The user was deleted successfully'], 204);
        }
        catch(ModelNotFoundException $err){
            return response()->json(['status'=>'error', "message" => "The requested user was not found"], 404);
        }

    }




    public function register (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>'error', 'data' => $validator->errors()->all()], 422);
        }

        $plainPassword=$request->password;
        $password=bcrypt($request->password);
        $request->request->add(['password' => $password]);

        // create the user account
        $created=User::create($request->all());
        $request->request->add(['password' => $plainPassword]);
        return response()->json(['status'=>'success', 'message' => 'User registered succesfully'], 200);


    }


    public function login (Request $request) {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'result' =>false,
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome back ' . Auth::user()->name,
            'data' => Auth::user(),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
        ], 200);
    }

    public function logout(Request $request) {

        $token = $request->user()->token();
        $token->revoke();
        $response = 'You have been successfully logged out!';
        return response()->json(['status'=>'success', 'message' => $response], 200);
    }
}
