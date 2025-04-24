<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokModel;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class StokController extends Controller
{
    public function index()
    {
        $activeMenu = 'stok';
        $breadcrumb = (object) [
            'title' => 'Manajemen Stok',
            'list' => ['Home', 'Stok']
        ];
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();

        return view('stok.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'barang' => $barang
        ]);
    }

    public function getStok(Request $request)
    {
        $stok = StokModel::with('barang')->select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah');

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('barang_nama', function($row) {
                return $row->barang->barang_nama ?? '-';
            })
            ->addColumn('aksi', function ($stok) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax($id)
{
    $stok = StokModel::with(['barang', 'user'])->find($id);

    $page = (object)[
        'title' => 'Detail Stok'
    ];

    $breadcrumb = (object)[
        'title' => 'Stok',
        'list' => ['Stok', 'Detail']
    ];

    $activeMenu = 'stok';

    return view('stok.show_ajax', compact('stok', 'page', 'breadcrumb', 'activeMenu'));
}


    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        return view('stok.create_ajax', compact('barang'));
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'barang_id' => 'required|exists:m_barang,barang_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $data = $request->all();
        $data['user_id'] = auth()->user()->user_id ?? 1; // default sementara, ganti sesuai sistem loginmu

        StokModel::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil disimpan'
        ]);
    }

    public function edit_ajax($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        return view('stok.edit_ajax', compact('stok', 'barang'));
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'barang_id' => 'required|exists:m_barang,barang_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $stok = StokModel::find($id);
        if ($stok) {
            $stok->update($request->only(['barang_id', 'stok_tanggal', 'stok_jumlah']));
            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil diupdate'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data stok tidak ditemukan'
        ]);
    }

    public function confirm_ajax($id)
    {
        $stok = StokModel::find($id);
        return view('stok.confirm_ajax', compact('stok'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan'
            ]);
        }
        return redirect('/');
    }

    public function import()
    {
        return view('stok.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_stok');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            foreach ($data as $index => $row) {
                if ($index > 1) {
                    $insert[] = [
                        'barang_id' => $row['A'],
                        'user_id' => $row['B'],
                        'stok_tanggal' => $row['C'],
                        'stok_jumlah' => $row['D'],
                        'supplier_id' => $row['E'],
                        'created_at' => now()
                    ];
                }
            }

            if (!empty($insert)) {
                StokModel::insertOrIgnore($insert);
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil diimport'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data kosong'
            ]);
        }

        return redirect('/');
    }

    public function export_excel()
    {
        $stok = StokModel::with(['barang', 'user', 'supplier'])->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Barang');
        $sheet->setCellValue('C1', 'User');
        $sheet->setCellValue('D1', 'Tanggal');
        $sheet->setCellValue('E1', 'Jumlah');
        $sheet->setCellValue('F1', 'Supplier');

        $row = 2;
        foreach ($stok as $index => $s) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $s->barang->barang_nama ?? '');
            $sheet->setCellValue('C' . $row, $s->user->name ?? '');
            $sheet->setCellValue('D' . $row, $s->stok_tanggal);
            $sheet->setCellValue('E' . $row, $s->stok_jumlah);
            $sheet->setCellValue('F' . $row, $s->supplier->supplier_nama ?? '');
            $row++;
        }

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Stok_' . now()->format('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $stok = StokModel::with(['barang', 'user', 'supplier'])->get();

        $pdf = Pdf::loadView('stok.export_pdf', compact('stok'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Data Stok' . now()->format('Y-m-d_His') . '.pdf');
    }
}
