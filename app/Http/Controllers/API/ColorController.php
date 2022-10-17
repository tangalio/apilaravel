<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Color;
use Illuminate\Support\Facades\File;

class ColorController extends Controller
{
    public function index()
    {
        $color = Color::all();
        return response()->json([
            'status' => 200,
            'color' => $color,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $color = new Color;
            $color->name = $request->input('name');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/color/', $filename);
                $color->image = 'uploads/color/' . $filename;
            }
            $color->status = $request->input('status') == true ? '1' : '0';
            $color->save();
            return response()->json([
                'status' => 200,
                'message' => 'Color Added Successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $color = Color::find($id);
        if ($color) {
            return response()->json([
                'status' => 200,
                'color' => $color
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Color Id Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $color = Color::find($id);
            if ($color) {
                $color->name = $request->input('name');
                if ($request->hasFile('image')) {
                    $path = $color->image;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/color/', $filename);
                    $color->image = 'uploads/color/' . $filename;
                }
                $color->status = $request->input('status') == true ? '1' : '0';
                $color->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Color Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Color ID Found',
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $color = Color::find($id);
        if ($color) {
            $color->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Color Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Color ID Found',
            ]);
        }
    }
}
