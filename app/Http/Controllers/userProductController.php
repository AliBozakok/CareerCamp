<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class userProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q= Product::query();
        if(request()->has('title'))
        {
            $q->where('title','LIKE',$request->tilte.'%');
        }
        $products= $q->get();
        return response()->json(["data"=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product= Product::findOrFail($id);
        return response()->json(["data"=>$product]);
    }

   public function recent()
   {
    $products= Product::getActive()->orderby('created_at','desc')->get();
    return response()->json(["data"=>$products]);
   }

}
