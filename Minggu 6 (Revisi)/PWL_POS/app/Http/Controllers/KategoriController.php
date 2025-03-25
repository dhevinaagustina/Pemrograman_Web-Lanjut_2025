<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori yang tersedia dalam sistem'
        ];

        $activeMenu = 'kategori';

        // Ambil semua data kategori
        $kategori = KategoriModel::all();

        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function getKategori(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($kategori) {
                    return '
                        <a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a>
                        <a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '" class="d-inline-block">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\');">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kategori Baru'
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string'
        ]);

        KategoriController::create($request->all());

        return redirect('/kategori')->with('success', 'Data Kategori berhasil ditambahkan');
    }

    public function show($id)
    {
        $kategori = KategoriModel::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function edit($id)
    {
        $kategori = KategoriModel::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string'
        ]);

        $kategori = KategoriModel::findOrFail($id);
        $kategori->update($request->all());

        return redirect('/kategori')->with('success', 'Data Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = KategoriModel::find($id);

        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data Kategori tidak ditemukan');
        }

        try {
            $kategori->delete();
            return redirect('/kategori')->with('success', 'Data Kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data Kategori gagal dihapus karena masih terkait dengan data lain');
        }
    }
    

    
}
