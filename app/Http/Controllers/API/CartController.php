<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::check()){
            $userID = Auth::id();
            return Cart::where('customer_id',$userID)->get();
        }
        
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
                'product_id' => 'required|max:191|exists:products,id',
                'quantity' => 'required|numeric',
                'orderDate' => 'required|date',
                'deliveryDate' => 'required|date',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'validation_errors' => $validator->messages(),
                ]);
            }
            else{
                $userID = Auth::id();
                $cart = new Cart();
                $cart->product_id = $request->input('product_id');
                $cart->customer_id = $userID;
                $cart->quantity = $request->input('quantity');
                $cart->orderDate = $request->input('orderDate');
                $cart->deliveryDate = $request->input('deliveryDate');

                $cart->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cart Added Successfully',
                ]);
            }
        }
        else {
            return response()->json([
                'status' => 400,
                'message' => 'Cart fail',
            ]);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
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
                'product_id' => 'required|max:191|exists:products,id',
                'quantity' => 'required|numeric',
                'orderDate' => 'required|date',
                'deliveryDate' => 'required|date',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'validation_errors' => $validator->messages(),
                ]);
            }
            else{
                $userID = Auth::id();
                $cart = Cart::find($id);
                $cart->product_id = $request->input('product_id');
                $cart->customer_id = $userID;
                $cart->quantity = $request->input('quantity');
                $cart->orderDate = $request->input('orderDate');
                $cart->deliveryDate = $request->input('deliveryDate');

                $cart->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cart Added Successfully',
                ]);
            }
        }
        else {
            return response()->json([
                'status' => 400,
                'message' => 'Cart fail',
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
        if (Auth::check()) {
            $userID = Auth::id();
            $cart = Cart::find($id);
                // cart phair cuar customer login
                if ($cart->customer_id == $userID) {
                    # code...
                    $cart->delete();
                    return response()->json([
                            'status' => 200,
                            'message' => 'Cart Deleted Successfully',
                        ]);
                }
                else {
                    return response()->json([
                            'status' => 404,
                            'message' => 'Can not delete this cart',
                    ]);
                }
                
            }

    }
}
