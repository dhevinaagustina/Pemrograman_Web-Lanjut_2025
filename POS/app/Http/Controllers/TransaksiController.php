<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\PenjualanDetailModel;
use App\Models\StokModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;



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
            $data = PenjualanModel::with('details')->orderBy('penjualan_tanggal', 'desc');
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('stok_jumlah', function ($transaksi) {
                    $totalStokAwal = 0; // Inisialisasi total stok awal
                
                    foreach ($transaksi->details as $detail) { // Loop tiap detail barang dalam transaksi
                        $stok = \App\Models\StokModel::where('barang_id', $detail->barang_id)->first(); // Ambil data stok berdasarkan barang_id
                
                        if ($stok) {
                            $totalStokAwal += $stok->stok_jumlah; // Tambahkan jumlah stok ke total
                        }
                    }
                
                    return $totalStokAwal; // Kembalikan total stok awal
                })
                
                ->addColumn('stok_setelah', function ($transaksi) {
                    $totalStokAwal = 0; // Inisialisasi total stok awal
                    $totalTerjual = 0; // Inisialisasi total jumlah barang yang terjual
                
                    foreach ($transaksi->details as $detail) { // Loop tiap detail barang dalam transaksi
                        $stok = \App\Models\StokModel::where('barang_id', $detail->barang_id)->first(); // Ambil data stok berdasarkan barang_id
                
                        if ($stok) {
                            $totalStokAwal += $stok->stok_jumlah; // Tambah stok awal
                            $totalTerjual += $detail->jumlah; // Tambah jumlah yang terjual dari detail transaksi
                        }
                    }
                
                    $stokSetelah = $totalStokAwal - $totalTerjual; // Hitung sisa stok setelah penjualan
                    return $stokSetelah; // Kembalikan stok setelah transaksi
                })
                
                ->addColumn('barang_dibeli', function ($transaksi) {
                    $namaBarang = []; // Inisialisasi array untuk nama barang
                
                    foreach ($transaksi->details as $detail) { // Loop tiap detail transaksi
                        if ($detail->barang) {
                            $namaBarang[] = $detail->barang->barang_nama; // Ambil nama barang dan masukkan ke array
                        }
                    }
                
                    return implode(', ', $namaBarang); // Gabungkan nama-nama barang dengan koma dan kembalikan sebagai string
                })
                
                
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

    public function store(Request $request)
{
    $request->validate([
        'penjualan_tanggal' => 'required|date',
        'barang_id' => 'required|array',
        'barang_id.*' => 'exists:m_barang,barang_id',
        'jumlah' => 'required|array',
        'jumlah.*' => 'numeric|min:1',
        'harga' => 'required|array',
        'harga.*' => 'numeric|min:0',
    ]);

    DB::beginTransaction();
    try {
        $userId = auth()->id() ?? 1;

        $penjualan = PenjualanModel::create([
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'user_id' => $userId,
        ]);

        foreach ($request->barang_id as $index => $barang_id) {
            $jumlah = $request->jumlah[$index];
            $harga = $request->harga[$index];

            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barang_id,
                'jumlah' => $jumlah,
                'harga' => $harga
            ]);

            StokModel::create([
                'barang_id' => $barang_id,
                'user_id' => $userId,
                'stok_tanggal' => $request->penjualan_tanggal,
                'stok_jumlah' => -abs($jumlah),
                'supplier_id' => null,
            ]);
        }

        DB::commit();
        return response()->json(['status' => true, 'message' => 'Transaksi berhasil disimpan.']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

public function store_ajax(Request $request)
{
    $validator = Validator::make($request->all(), [
        'kode' => 'required|string|unique:t_penjualan,penjualan_kode',
        'tanggal' => 'required|date',
        'nama_pelanggan' => 'required|string|min:3',
        'items' => 'required|array|min:1',
        'items.*.barang_id' => 'required|integer|exists:t_barang,barang_id',
        'items.*.jumlah' => 'required|integer|min:1',
        'items.*.harga' => 'required|integer|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi gagal',
            'msgField' => $validator->errors()
        ]);
    }

    DB::beginTransaction();
    try {
        // Simpan data transaksi
        $transaksi = new \App\Models\PenjualanModel();
        $transaksi->penjualan_kode = $request->kode;
        $transaksi->penjualan_tanggal = $request->tanggal;
        $transaksi->pembeli = $request->nama_pelanggan;
        $transaksi->user_id = auth()->id();
        $transaksi->save();

        foreach ($request->items as $item) {
            // Simpan detail transaksi
            \App\Models\PenjualanDetailModel::create([
                'penjualan_id' => $transaksi->penjualan_id,
                'barang_id' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
            ]);

            // Update stok barang
            $barang = \App\Models\BarangModel::find($item['barang_id']);
            if ($barang->stok < $item['jumlah']) {
                throw new \Exception("Stok barang '{$barang->nama_barang}' tidak cukup.");
            }
            $barang->stok -= $item['jumlah'];
            $barang->save();
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Transaksi berhasil disimpan'
        ]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'status' => false,
            'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
        ]);
    }
}


    public function export_excel()
    {
        $penjualans = PenjualanModel::with(['user', 'details.barang'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'User');
        $sheet->setCellValue('C1', 'Barang');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Harga');
        $sheet->setCellValue('F1', 'Total');

        $row = 2;
        foreach ($penjualans as $penjualan) {
            foreach ($penjualan->details as $detail) {
                $sheet->setCellValue('A' . $row, $penjualan->penjualan_tanggal);
                $sheet->setCellValue('B' . $row, $penjualan->user->user_nama ?? '-');
                $sheet->setCellValue('C' . $row, $detail->barang->barang_nama ?? '-');
                $sheet->setCellValue('D' . $row, $detail->jumlah);
                $sheet->setCellValue('E' . $row, $detail->harga);
                $sheet->setCellValue('F' . $row, $detail->jumlah * $detail->harga);
                $row++;
            }
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Transaksi ' . date('Y-m-d_H-i-s') . '.xlsx';

        return Response::streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function import_excel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        $spreadsheet = IOFactory::load($request->file('file'));
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                if ($index === 0) continue;

                $tanggal = $row[0];
                $barangNama = $row[2];
                $jumlah = (int)$row[3];
                $harga = (int)$row[4];

                // Cari barang berdasarkan nama
                $barang = \App\Models\BarangModel::where('barang_nama', $barangNama)->first();

                if (!$barang) continue;

                $penjualan = PenjualanModel::firstOrCreate([
                    'penjualan_tanggal' => $tanggal,
                    'user_id' => auth()->user()->user_id ?? 1
                ]);

                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barang->barang_id,
                    'jumlah' => $jumlah,
                    'harga' => $harga
                ]);

                StokModel::create([
                    'barang_id' => $barang->barang_id,
                    'user_id' => auth()->user()->user_id ?? 1,
                    'stok_tanggal' => $tanggal,
                    'stok_jumlah' => -$jumlah,
                    'supplier_id' => null
                ]);
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Import berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi.index')->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function confirm_ajax($id)
    {
        $penjualan = PenjualanModel::findOrFail($id);
    
        // Simulasikan perubahan status tanpa menyimpan ke DB
        return response()->json([
            'message' => 'Transaksi berhasil dikonfirmasi.',
            'data' => [
                'penjualan_id' => $penjualan->penjualan_id,
                'penjualan_kode' => $penjualan->penjualan_kode,
                'status' => 'confirmed' // ini hanya virtual
            ]
        ]);
    }
    

    public function create_ajax()
    {
        $page = (object)[
            'title' => 'Tambah Transaksi'
        ];
    
        return view('transaksi.create_ajax', compact('page'));
    }
    

    public function edit_ajax($id)
    {
        $penjualan = PenjualanModel::with('details')->findOrFail($id);
        return view('transaksi.edit_ajax', compact('penjualan'));
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach (array_slice($data, 1) as $row) {
            // Asumsi urutan kolom: No Transaksi | Tanggal | Nama Pelanggan | Total | Status
            PenjualanModel::create([
                'no_transaksi' => $row[0],
                'tanggal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
                'nama_pelanggan' => $row[2],
                'total' => $row[3],
                'status' => $row[4] ?? 'pending',
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diimpor.');
    }

}
