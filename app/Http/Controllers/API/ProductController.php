<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index($id=null)
    {
        // $products = Product::all();
        // return response()->json([
        //     'status' => 200,
        //     'products' => $products
        // ]);

        if ($id == null) {
            $products = Product::all();
            return response()->json([
                    'status' => 200,
                    'products' => $products
                ]);
        }
        else{
            $products = Product::find($id);
            return response()->json([
                'status' => 200,
                'products' => $products
            ]);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'color_id' => 'required|max:191',
            'size_id' => 'required|max:191',
            'name' => 'required|max:191',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'qty' => 'required|max:4',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $product = new Product;
            $product->category_id = $request->input('category_id');
            $product->category_id = $request->input('color_id');
            $product->category_id = $request->input('size_id');

            $product->name = $request->input('name');
            $product->description = $request->input('description');

            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');
            $product->qty = $request->input('qty');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
            //     $file->move('uploads/product/', $filename);
            //     $product->image = 'uploads/product/' . $filename;
                $product->image = $file->storeAs('products', $filename);
            }

            

            $product->featured = $request->input('featured') == true ? '1' : '0';
            $product->popular = $request->input('popular') == true ? '1' : '0';
            $product->status = $request->input('status') == true ? '1' : '0';
            $product->save();

            return response()->json([
                'status' => 200,
                'message' => 'Product Added Successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Product Found',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'color_id' => 'required|max:191',
            'size_id' => 'required|max:191',
            'name' => 'required|max:191',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'qty' => 'required|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $product = Product::find($id);
            if ($product) {

                $product->category_id = $request->input('category_id');
                $product->category_id = $request->input('color_id');
                $product->category_id = $request->input('size_id');

                $product->name = $request->input('name');
                $product->description = $request->input('description');

                $product->selling_price = $request->input('selling_price');
                $product->original_price = $request->input('original_price');
                $product->qty = $request->input('qty');

                if ($request->hasFile('image')) {
                    $path = $product->image;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $product->image = $file->storeAs('products', $filename);
                }

                $product->featured = $request->input('featured');
                $product->popular = $request->input('popular');
                $product->status = $request->input('status');
                $product->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Product Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product Not Found',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Product Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Product ID Found',
            ]);
        }
    }
}
