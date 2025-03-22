<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    // Menampilkan halaman daftar barang
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang tersedia dalam sistem'
        ];

        $activeMenu = 'barang'; // Set menu yang sedang aktif

        $barang = BarangModel::all();

        return view('barang.index', compact('breadcrumb', 'barang', 'page', 'activeMenu'));
    }

    // Mengambil data barang dalam format JSON untuk DataTables
    public function getBarang(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangModel::with('kategori')->select('m_barang.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->kategori_nama : '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '<a href="'.route('barang.show', $row->barang_id).'" class="btn btn-info btn-sm">Detail</a> 
                            <a href="'.route('barang.edit', $row->barang_id).'" class="btn btn-warning btn-sm">Edit</a> 
                            <form action="'.route('barang.destroy', $row->barang_id).'" method="POST" style="display:inline;">
                                '.csrf_field().'
                                '.method_field("DELETE").'
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }


    // Menampilkan halaman tambah barang
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Barang Baru'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all(); // Mengambil semua kategori

        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|string|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0'
        ]);

        BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual
        ]);

        return redirect('/barang')->with('success', 'Data Barang berhasil ditambahkan');
    }

    // Menampilkan halaman edit barang
    public function edit($id)
    {
        $barang = BarangModel::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Barang'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all(); // Mengambil semua kategori

        return view('barang.edit', compact('breadcrumb', 'page', 'barang', 'activeMenu', 'kategori'));
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_kode' => 'required|string|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0'
        ]);

        $barang = BarangModel::findOrFail($id);
        $barang->update([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual
        ]);

        return redirect('/barang')->with('success', 'Data Barang berhasil diperbarui');
    }

    // Menghapus data barang
    public function destroy($id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return redirect('/barang')->with('error', 'Data Barang tidak ditemukan');
        }

        try {
            $barang->delete();
            return redirect('/barang')->with('success', 'Data Barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/barang')->with('error', 'Data Barang gagal dihapus karena masih terkait dengan data lain');
        }
    }

    // Menampilkan detail barang
    public function show($id)
    {
        $barang = BarangModel::with('kategori')->findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', compact('breadcrumb', 'page', 'barang', 'activeMenu'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $barang = BarangModel::with('kategori')->select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual');
    
            return DataTables::of($barang)
                ->addIndexColumn()
                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->kategori_nama : '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <a href="' . url('barang/' . $row->barang_id) . '" class="btn btn-sm btn-info">Detail</a>
                        <a href="' . url('barang/' . $row->barang_id . '/edit') . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . url('barang/' . $row->barang_id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</button>
                        </form>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

    }
}
