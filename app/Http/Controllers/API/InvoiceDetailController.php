<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoice_detail = InvoiceDetail::all();
        return response()->json([
            'status'=>200,
            'invoice_detail'=>$invoice_detail
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
            'invoice_id' => 'required|exists:invoice,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric'
            
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }
        else{
            $invoice_detail = new InvoiceDetail();
            $invoice_detail->invoice_id = $request->input('invoice_id');
            $invoice_detail->product_id = $request->input('product_id');
            $invoice_detail->quantity = $request->input('quantity');
            $invoice_detail->save();
            return response()->json([
                'status'=> 200,
                'message'=>'InvoiceDetail Add Success'
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
            // 'invoice_id' => 'required|exists:invoice,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric'
            
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }
        else{
            $invoice_detail = InvoiceDetail::find($id);
            // $invoice_detail->invoice_id = $id;
            $invoice_detail->product_id = $request->input('product_id');
            $invoice_detail->quantity = $request->input('quantity');
            $invoice_detail->save();
            return response()->json([
                'status'=> 200,
                'message'=>'InvoiceDetail Update Success'
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
        $invoice_detail = InvoiceDetail::find($id);
        if($invoice_detail){
            $invoice_detail->delete();
            return response()->json([
                'status'=>200,
                'message'=>'InvoiceDetail Delete Success'
            ]);
        }
        else{
            return response()->json([
                'status'=>400,
                'message'=>'Can not find InvoiceDetail id'
            ]);
        }
    }
}
