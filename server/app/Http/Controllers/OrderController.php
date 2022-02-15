<?php

namespace App\Http\Controllers;

use App\Mail\OrderEmail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return response([
            'status' => 'success',
            'data' => [
                'results' => $orders->count(),
                'orders' => $orders,
            ],
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $validated = $request->validate(['tel' => 'bail|required',
            'description' => 'required', 'photo' => 'string',
            'fullname' => 'required|string', 'type' => 'required|string']);

        // $user = User::where('tel', $validated['tel']);

        $order = Order::create($request->only('tel', 'fullname', 'description', 'type', 'photo'));

        Mail::to('kaka@test.com')->send(new OrderEmail(tel:$order['tel'], fullname:$order['fullname'], description:$order['description'], type:$order['type'], created_at:$order['created_at'], photo:$order['photo']));
        return response([
            'status' => 'success',
            'message' => 'Order has been created successfully',
        ], 201);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}