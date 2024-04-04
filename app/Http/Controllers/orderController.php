<?php

namespace App\Http\Controllers;

use App\Http\Resources\orderResource;
use Illuminate\Http\Request;
use App\Models\Order;
class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order= Order::where('userId',auth('user')->id())->get();
        return orderResource::collection($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->validate([
            'address'=>['required'],
            'phone'=>['required'],
        ]);
        $orderId= Order::latest()->first();
        if(!$orderId)
        {
            $orderId= 1;
        }
        else
        {
            $orderId= $orderId->id +1;
        }

    }




}
