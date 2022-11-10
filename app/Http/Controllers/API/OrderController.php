<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $order = Order::all();
        return response()->json([
            'status' => 200,
            'products' => $order
        ]);
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
        if (Auth::check()) {

            $validator = Validator::make($request->all(), [
                'status' => 'required|numeric',
                'orderDate' => 'required|date',
                'deliveryDate' => 'required|date',
                'payment' => 'required'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'validation_errors' => $validator->messages(),
                ]);
            }
            else{
                $userID = Auth::id();
                $order = new Order();
                $order->customer_id = $userID;
                $order->orderDate = $request->input('orderDate');
                $order->deliveryDate = $request->input('deliveryDate');
                $order->status =$request->input('status');
                $order->payment =$request->input('payment');

                $order->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Order Added Successfully',
                ]);
            }
        }
        else { 
            return response()->json([
                'status' => 400,
                'message' => 'Order add fail',
            ]);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if (Auth::check()) {

            $validator = Validator::make($request->all(), [
                'status' => 'required|numeric',
                'orderDate' => 'required|date',
                'deliveryDate' => 'required|date',
                'payment' => 'required'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'validation_errors' => $validator->messages(),
                ]);
            }
            else{
                $userID = Auth::id();
                $order = Order::find($id);
                $order->customer_id = $userID;
                $order->orderDate = $request->input('orderDate');
                $order->deliveryDate = $request->input('deliveryDate');
                $order->status =$request->input('status');
                $order->payment =$request->input('payment');

                $order->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Order Update Successfully',
                ]);
            }
        }
        else { 
            return response()->json([
                'status' => 400,
                'message' => 'Order update fail',
            ]);
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
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Order Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Order ID Found',
            ]);
        }
    }
}
