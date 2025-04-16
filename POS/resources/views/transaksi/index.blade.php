@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Transaksi</h3>
        <div class="card-tools d-flex flex-wrap gap-2">
            <button onclick="modalAction('{{ url('/transaksi/import') }}')" class="btn btn-info">
                <i class="fas fa-file-import mr-1"></i> Import Transaksi
            </button>
            <a href="{{ url('/transaksi/export_excel') }}" class="btn btn-primary">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="{{ url('/transaksi/export_pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </a>
            <button onclick="modalAction('{{ url('/transaksi/create_ajax') }}')" class="btn btn-success">
                <i class="fas fa-plus-square mr-1"></i> Tambah Transaksi (Ajax)
            </button>
        </div>
    </div>

    <div class="card-body">
        <!-- Filter jika diperlukan -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="transaksi_filter" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="transaksi_filter" class="form-control form-control-sm" id="transaksi_filter">
                                <option value="">- Semua Transaksi -</option>
                                {{-- Tambahkan filter jika ada --}}
                            </select>
                            <small class="form-text text-muted">Pilih filter jika tersedia</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table id="datatable-transaksi" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                    <th>Barang Dibeli</th>
                    <th>Stok Awal</th> <!-- Kolom Baru -->
                    <th>Stok Setelah Transaksi</th> <!-- Kolom Baru -->
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
    data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true">
</div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    var dataTransaksi;

    $(document).ready(function () {
        dataTransaksi = $('#datatable-transaksi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('transaksi.list') }}",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d.transaksi_filter = $('#transaksi_filter').val(); // Optional filter
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'penjualan_kode', name: 'penjualan_kode' },
                { data: 'pembeli', name: 'pembeli' },
                { data: 'penjualan_tanggal', name: 'penjualan_tanggal' },
                { data: 'barang_dibeli', name: 'barang_dibeli' },
                { data: 'stok_jumlah', name: 'stok_jumlah' }, // Kolom Stok
                { data: 'stok_setelah', name: 'stok_setelah' }, // Stok Setelah
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });

        $('#transaksi_filter').on('change', function () {
            dataTransaksi.ajax.reload();
        });
    });

    function showDetail(id) {
        $.get('/transaksi/' + id + '/show_ajax', function(data) {
            $('#myModal').html(data);
            $('#myModal').modal('show');
        });
    }
</script>
@endpush
