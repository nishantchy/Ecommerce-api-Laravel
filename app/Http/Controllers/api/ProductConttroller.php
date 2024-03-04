<?php

namespace App\Http\Controllers\api;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductConttroller extends Controller
{
    public function index(){
        $product = Products::all();
        if($product->count()>0){
            return response()->json([
                'status'=>200,
                'message'=>$product
            ],200);
        }
        else{
            return response()->json([
                'status'=>404,
                'errors'=> 'No records found'
            ],404);
        }
       } 



    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'sale_price' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($req) {
                    if ($value > $req->input('list_price')) {
                        $fail('The sale price must be less than or equal to the list price.');
                    }
                },
            ],
            'stocks' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'details' => 'required',
            'category' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=> $validator->messages()
            ],422);
        }
        else{
            $product = Products::create([
                'name' => $req->name,
                'list_price' => $req->list_price,
                'sale_price' => $req->sale_price,
                'stocks' => $req->stocks,
                'image' => $req->file('image')->store('images', 'public'),
                'details' => $req->details,
                'category' => $req->category,
            ]);
            if($product){
                return response()->json([
                    'status'=>200,
                    'message'=>'Product Inserted Successfully'
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
}
