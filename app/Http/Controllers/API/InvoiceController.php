<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoice = Invoice::all();
        return response()->json([
            'status' => 200,
            'invoice' => $invoice,
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
            'status' => 'required|max:2|numeric',
            'supplier_id' => 'required|numeric',
            'createby' => 'required|numeric',
            'createdate' =>'required|date',
            'deletedby' => 'required|numeric',
            'deletedate' =>'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        else{
            $invoice = new Invoice();
            $invoice->status = $request->input('status');
            $invoice->supplier_id = $request->input('supplier_id');
            $invoice->createby = $request->input('createby');
            $invoice->createdate = $request->input('createdate');
            $invoice->deletedby = $request->input('deletedby');
            $invoice->deletedate = $request->input('deletedate');
            $invoice->save();
            return response()->json([
                'status' => 200,
                'message' => 'Invoice Add Success'
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
            'status' => 'required|max:2|numeric',
            'supplier_id' => 'required|numeric',
            'createby' => 'required|numeric',
            'createdate' =>'required|date',
            'deletedby' => 'required|numeric',
            'deletedate' =>'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        else{
            $invoice = Invoice::find($id);
            $invoice->status = $request->input('status');
            $invoice->supplier_id = $request->input('supplier_id');
            $invoice->createby = $request->input('createby');
            $invoice->createdate = $request->input('createdate');
            $invoice->deletedby = $request->input('deletedby');
            $invoice->deletedate = $request->input('deletedate');
            $invoice->save();
            return response()->json([
                'status' => 200,
                'message' => 'Invoice update Success'
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
        $invoice= Invoice::find($id);
        if($invoice){
            $invoice->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Invoice delete Success'
            ]);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'Invoice delete failed'
            ]);
        }
    }
}
