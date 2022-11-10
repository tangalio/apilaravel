<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orderdetail = OrderDetail::all();
        return response()->json([
            'status' => 200,
            'OrderDetail' => $orderdetail
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
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|max:191|exists:products,id',
            'quantity' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            # code...
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }
        else{
            $orderdetail = new OrderDetail();
            $orderdetail->product_id = $request->input('product_id');
            $orderdetail->quantity = $request->input('quantity');
            $orderdetail->save();
            return response()->json([
                'status' => 200,
                'message' => 'OrderDetail Add Success'
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
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|max:191|exists:products,id',
            'quantity' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            # code...
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }
        else{
            if (OrderDetail::find($id)) {
                # code...
                $orderdetail = OrderDetail::find($id);
                $orderdetail->product_id = $request->input('product_id');
                $orderdetail->quantity = $request->input('quantity');
                $orderdetail->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'OrderDetail Update Success'
                ]);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => 'OrderDetail Update failed'
                ]);
            }
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
        if (OrderDetail::find($id)) {
            # code...
            $orderdetail = OrderDetail::find($id);
            $orderdetail->delete();
            return response()->json([
                'status' => 200,
                'message' => 'OrderDetail delete Success'
            ]);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'OrderDetail delete failed'
            ]);
        }
    }
}
