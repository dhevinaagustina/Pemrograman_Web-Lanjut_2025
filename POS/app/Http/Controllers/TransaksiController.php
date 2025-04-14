<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Yajra\DataTables\Facades\DataTables;


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

public function getPenjualan(Request $request)
{
    if ($request->ajax()) {
        $data = PenjualanModel::orderBy('penjualan_tanggal', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($transaksi) {
                $btn = '<button onclick="modalAction(\''.url('/transaksi/'.$transaksi->penjualan_id.'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\''.url('/transaksi/'.$transaksi->penjualan_id.'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\''.url('/transaksi/'.$transaksi->penjualan_id.'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
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
