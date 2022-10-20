<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        //
        if ($id == null) {
            return User::all();
        }
        else{
            return User::find($id);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //them ben dang ky
        //'id', 'name', 'email', 'phone', 'address', 'status', 'role_as'

        $validator = Validator::make($req->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'status' => 'required',
            'role_as' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }

        else{
            $data = $req->only('id', 'name', 'email', 'phone', 'address', 'status', 'role_as');
            return User::create($data);
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
    public function update(Request $req, $id)
    {
        //sua thong tin k bao gom doi mat khau

        $validator = Validator::make($req->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'phone' => 'required|size:12',
            'address' => 'required',
            'status' => 'required',
            'role_as' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }

        else{
            $user = User::findOrFail($id);
            $data = $req->only('id', 'name', 'email', 'phone', 'address', 'status', 'role_as');
            return $user->update($data);
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
        //chinh sua trang thai tai khoan
    }

    public function disable($id){
        $user = User::findOrFail($id);
    }
}
