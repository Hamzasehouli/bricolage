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

        $request->validate(['tel' => 'bail|required',
            'description' => '', 'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fullname' => 'required|string', 'type' => 'required|string']);

        // $user = User::where('tel', $validated['tel']);

        // $token = explode(' ', $request->header('Authorization'))[1];
        // return User::where('id', 1)->first();

        // exit;
        // $order = Order::create($request->only('tel', 'fullname', 'description', 'type', 'photo'));
        // $path = $request->file('photo')->store('orders');
        // echo $path;
        // exit;

        function path($num)
        {
            $str = 'azertyuiopmlkjhgfdsqwxcvbnAZERTYUIOPMLKJHGFDSQWXVBN1234567890';
            $strLng = strlen($str);
            $path = '';
            for ($i = 0; $i < $num; $i++) {
                $randomNumber = rand(0, $strLng - 1);
                $path .= $str[$randomNumber];
            }
            return $path;
        }
        $path = path(20);

        $imageName = time() . '-' . $path . '.' . $request->photo->extension();
        $request->photo->move(public_path('images'), $imageName);

        Mail::to('team@fixup.com')->send(new OrderEmail(photo:$imageName, tel:$request['tel'], fullname:$request['fullname'], description:$request['description'], type:$request['type'], created_at:now()));

        // File::delete('images/' . $imageName);
        // return redirect()->route('delete-image', ['image' => $imageName]);

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
    public function deleteImage($image)
    {
        // File::delete('images/' . $image);

        return response([
            'status' => 'success',
            'message' => 'Order has been created successfully',
        ], 201);
    }
}