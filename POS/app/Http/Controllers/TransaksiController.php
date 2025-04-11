<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;


class TransaksiController extends Controller
{

public function index()
{
    $page = (object)[
        'title' => 'Data Transaksi'
    ];

    $breadcrumb = (object)[
        'title' => 'Transaksi',
        'list' => ['Home', 'Transaksi']
    ];

    $activeMenu = 'transaksi';

    return view('transaksi.index', compact('page', 'breadcrumb', 'activeMenu'));
}

public function getTransaksi(Request $request)
{
    $data = PenjualanModel::with('user')->get(); // pastikan relasi 'user' sudah dibuat di model Penjualan

    return datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
            return '
                <button onclick="showDetail(' . $row->penjualan_id . ')" class="btn btn-sm btn-info">Detail</button>
            ';
        })
        ->make(true);
}

public function show_ajax($id)
{
    $transaksi = PenjualanModel::with(['user', 'details.barang'])->find($id);

    $page = (object)[
        'title' => 'Detail Transaksi'
    ];

    return view('transaksi.show_ajax', compact('transaksi', 'page'));
}

}
