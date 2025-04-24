<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|max:100',
            'barang_nama' => 'required|string|max:100',
            'kategori_id' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/barang', $filename);
            $validated['image'] = $filename;
        }

        $barang = BarangModel::create($validated);
        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = BarangModel::findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'barang_kode' => 'sometimes|required|string|max:100',
            'barang_nama' => 'sometimes|required|string|max:100',
            'kategori_id' => 'sometimes|required|numeric',
            'harga_beli' => 'sometimes|required|numeric',
            'harga_jual' => 'sometimes|required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('image')) {
            if ($barang->image) {
                $oldFile = str_replace(url('/storage/barang/'), '', $barang->image);
                Storage::delete('public/barang/' . $oldFile);
            }

            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/barang', $filename);
            $validated['image'] = $filename;
        }

        $barang->update($validated);
        return response()->json($barang);
    }

    public function destroy($id)
    {
        $barang = BarangModel::findOrFail($id);

        if ($barang->image) {
            $filename = str_replace(url('/storage/barang/'), '', $barang->image);
            Storage::delete('public/barang/' . $filename);
        }

        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
