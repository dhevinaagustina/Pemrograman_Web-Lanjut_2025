<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    // Menampilkan halaman daftar supplier
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar Supplier yang tersedia dalam sistem'
        ];

        $activeMenu = 'supplier'; // Set menu yang sedang aktif
        
        $supplier = SupplierModel::all(); 
        return view('supplier.index', compact('breadcrumb', 'supplier', 'page', 'activeMenu'));

    }

    public function getSuppliers(Request $request)
    {
        $query = SupplierModel::query();

        if ($request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $data = $query->select('supplier_id', 'supplier_nama', 'supplier_telepon', 'supplier_alamat');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return '
                    <a href="' . route('supplier.show', $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a>
                    <a href="' . route('supplier.edit', $supplier->supplier_id) . '" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" action="' . route('supplier.destroy', $supplier->supplier_id) . '" class="d-inline-block">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\');">Hapus</button>
                    </form>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    // Menampilkan halaman tambah supplier
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Supplier Baru'
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Menyimpan data supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|string|unique:m_supplier,supplier_kode|max:50',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'nullable|string',
            'supplier_telepon' => 'nullable|string|max:20',
        ]);

        SupplierModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
            'supplier_telepon' => $request->supplier_telepon,
        ]);

        return redirect('/supplier')->with('success', 'Data Supplier berhasil ditambahkan');
    }

    // Menampilkan halaman edit supplier
    public function edit($id)
    {
        $supplier = SupplierModel::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', compact('breadcrumb', 'page', 'supplier', 'activeMenu'));
    }

    // Menyimpan perubahan data supplier
    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_kode' => 'required|string|max:50|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'nullable|string',
            'supplier_telepon' => 'nullable|string|max:20',
        ]);

        $supplier = SupplierModel::findOrFail($id);
        $supplier->update([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
            'supplier_telepon' => $request->supplier_telepon,
        ]);

        return redirect('/supplier')->with('success', 'Data Supplier berhasil diperbarui');
    }

    // Menghapus data supplier
    public function destroy($id)
    {
        $supplier = SupplierModel::find($id);

        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data Supplier tidak ditemukan');
        }

        try {
            $supplier->delete();
            return redirect('/supplier')->with('success', 'Data Supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data Supplier gagal dihapus karena masih terkait dengan data lain');
        }
    }

    // Menampilkan detail supplier
    public function show($id)
    {
        $supplier = SupplierModel::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.show', compact('breadcrumb', 'page', 'supplier', 'activeMenu'));
    }
}
