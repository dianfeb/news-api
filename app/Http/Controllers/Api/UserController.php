<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
      $data = User::get();
      return response()->json([
        'status' => true,
        'message' => 'Data Ditemukan',
        'data' => $data
      ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Data Gagal Ditambahkan",
                'data' => $validator->errors()
            ]);
        }

        $data = $validator->validate();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Ditambahkan',
            'data' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $data = user::find($id);

        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'data ditemukan',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan'
            ], 404);
           
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //


        $data = User::find($id);
        if(empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'nullable|min:5|confirmed',
        ]);
        
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Diubah',
                'data' => $validator->errors()
            ], 400);
        }
        
        $dataToUpdate = $validator->validated();
        if (isset($dataToUpdate['password'])) {
            $dataToUpdate['password'] = bcrypt($dataToUpdate['password']);
        }
        
        $data->update($dataToUpdate);
        
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Diubah',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = User::find($id);
        if(empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }
        
        User::find($id)->Delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Dihapus',
        ], 200);
    }
}
