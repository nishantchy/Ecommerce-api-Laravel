<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        'password'=> 'required',
        'password_confirm'=>'required|same:password'
    ]);
    if($validator->fails()){
        return response()->json([
            'status'=>422,
            'message'=> $validator->messages()
        ],422);
    }
    else{
        $user = User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>$req->password,
        ]);
    }
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
