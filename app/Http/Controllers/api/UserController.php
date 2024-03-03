<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   public function index(){
    $user = User::all();
    if($user->count()>0){
        return response()->json([
            'status'=>200,
            'message'=>$user
        ],200);
    }
    else{
        return response()->json([
            'status'=>404,
            'message'=> 'No records found'
        ],404);
    }
   } 

   public function store(Request $req){
    $validator = Validator::make($req->all(), [
        'name'=> 'required|max:191',
        'email'=> 'required|email|max:191',
        'password'=> 'required|min:8',
        'password_confirm'=>'required|same:password'
    ]);
    if($validator->fails()){
        return response()->json([
            'status'=>422,
            'errors'=> $validator->messages()
        ],422);
    }
    else{
        $user = User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>$req->password,
        ]);
        if($user){
            return response()->json([
                'status'=>200,
                'message'=>'User Registered Successfully'
            ],200);
        }
        else{
            return response()->json([
                'status'=> 500,
                'message'=> 'Something went wrong'
            ],500);
        }
    }
   }
   public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // If validation fails, return a 422 response with validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication successful, retrieve the authenticated user
            $user = Auth::user();

            // Return a success response with the authenticated user data
            return response()->json([
                'status' => 200,
                'user' => $user,
                'message' => 'Login successful'
            ], 200);
        } else {
            // Authentication failed, return a 401 response
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials'
            ], 401);
        }
    }
}
