<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        return KategoriModel::all();
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $kategori = KategoriModel::create($request->all());
        return response()->json($kategori, 201);
    }

    // Menampilkan detail satu kategori
    public function show($id)
    {
        $kategori = KategoriModel::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        return $kategori;
    }

    // Mengupdate kategori
    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        $kategori->update($request->all());
        return response()->json($kategori);
    }

    // Menghapus kategori
    public function destroy($id)
    {
        $kategori = KategoriModel::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        $kategori->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }
}
