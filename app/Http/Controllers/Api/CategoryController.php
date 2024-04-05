<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Category::get();
        return response()->json([
            'status' =>true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);

        // return CategoryResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Data Gagal Ditambahkan",
                'data' => $validator->errors()
            ]);
        }
        $data = $validator->validate();
        $data['slug'] = Str::slug($data['name']);
        Category::create($data);
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
        $data = Category::find($id);

        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Ditemukan',
                'data' => $data
            ], 200);
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $data = Category::find($id);
        if(empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Diubah',
                'data' => $validator->errors()
            ]);
        }
        $data = $validator->validate();
        $data['slug'] = Str::slug($data['name']);
        Category::find($id)->update($data);
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
        $data = Category::find($id);
        if(empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }
        
        Category::find($id)->Delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Dihapus',
        ], 200);
    }
}
