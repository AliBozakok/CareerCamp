<?php

namespace App\Http\Controllers;

use App\Http\Resources\cartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class cartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItem= Cart::where('userId',auth('user')->id())->get();
        return cartResource::collection($cartItem);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $input= $request->validate([
        'productId'=>['required'],
        'qty'=>['nullable','numeric']
    ]);
    $item= Cart::where('productId',$input['productId'])
    ->where('userId',auth('user')->id())->get();

    if(!$item)
    {   $input['userId'] = auth('user')->id();
        Cart::create($input);
        return response()->json(["message"=>"item is Added"]);
    }
    $cartQty= $item->qty;
    if($cartQty > $item->product->quantityInStock)
    {
        return response()->json(["meassage"=>"not avialable"]);
    }
    $item->qty= $cartQty +1;
    $item->save();
    return response()->json(["message"=>"quantity is updated "]);

    }


    public function update(Request $request, string $id)
    {
        $input= $request->validate(['qty'=>['required','numeric']]);
        $item= Cart::where('productId',$id)
        ->where('userId',auth('user')->id())->firtsOrFail();
        $cartQty= $item->qty + $input['qty'];
        if($cartQty > $item->product->quantityInStock)
        {
            return response()->json(["meassage"=>"not avialable"]);
        }
        $item->qty= $cartQty;
        $item->save();
        return response()->json(["message"=>"quantity is updated  'incraesed'"]);
    }

    public function remove(Request $request, string $id)
    {
        $input= $request->validate(['qty'=>['required','numeric']]);
        $item= Cart::where('productId',$id)
        ->where('userId',auth('user')->id())->firtsOrFail();
        $cartQty= $item->qty - $input['qty'];
        if($cartQty <= 1)
        {   $item->qty= 1;
            $item->save();
            return response()->json(["meassage"=>"minimum is 1"]);
        }
        $item->qty= $cartQty;
        $item->save();
        return response()->json(["message"=>"quantity is updated  'decraesed'"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item= Cart::where('productId',$id)
        ->where('userId',auth('user')->id())->firtsOrFail();
        $item->delete();
        return response()->json(["message"=>" product is deleted"]);
    }
}
