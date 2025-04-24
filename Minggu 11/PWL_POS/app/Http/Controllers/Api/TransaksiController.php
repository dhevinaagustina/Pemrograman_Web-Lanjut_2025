<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = PenjualanModel::with(['user', 'details.barang'])->get();
        return response()->json($data);
    }
    
    public function show($transaksi)
    {
        $penjualan = PenjualanModel::with(['user', 'details.barang'])->findOrFail($transaksi);
        return response()->json($penjualan);
    }

    /** POST /api/transaksi */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_id'           => 'required|exists:m_user,user_id',
            'pembeli'           => 'required|string|max:100',
            'penjualan_kode'    => 'required|string|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($v->fails()) {
            return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        }

        $trx = PenjualanModel::create($v->validated());

        if ($request->hasFile('image')) {
            $fn = time().'.'.$request->image->extension();
            $request->image->storeAs('public/transaksi', $fn);
            $trx->update(['image'=>$fn]);
        }

        return response()->json($trx, 201);
    }

    // /** GET /api/transaksi/{transaksi} */
    // public function show($transaksi)
    // {
    //     $trx = PenjualanModel::findOrFail($transaksi);
    //     return response()->json($trx);
    // }

    /** PUT /api/transaksi/{transaksi} */
    public function update(Request $request, $transaksi)
    {
        $trx = PenjualanModel::findOrFail($transaksi);

        $v = Validator::make($request->all(), [
            'pembeli'           => 'sometimes|required|string|max:100',
            'penjualan_kode'    => 'sometimes|required|string|unique:t_penjualan,penjualan_kode,'.$transaksi.',penjualan_id',
            'penjualan_tanggal' => 'sometimes|required|date',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($v->fails()) {
            return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        }

        $trx->update($v->validated());

        if ($request->hasFile('image')) {
            if ($trx->image) {
                Storage::delete('public/transaksi/'.$trx->image);
            }
            $fn = time().'.'.$request->image->extension();
            $request->image->storeAs('public/transaksi', $fn);
            $trx->update(['image'=>$fn]);
        }

        return response()->json($trx);
    }

    /** DELETE /api/transaksi/{transaksi} */
    public function destroy($transaksi)
    {
        $trx = PenjualanModel::findOrFail($transaksi);
        if ($trx->image) {
            Storage::delete('public/transaksi/'.$trx->image);
        }
        $trx->delete();
        return response()->json(['success'=>true,'message'=>'Transaksi dihapus']);
    }
}
