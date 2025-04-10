@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Supplier</h3>
        <div class="card-tools d-flex flex-wrap gap-2">
            <button onclick="modalAction('{{ url('/supplier/import') }}')" class="btn btn-info">
                <i class="fas fa-file-import mr-1"></i> Import Supplier
            </button>
            <a href="{{ url('/supplier/export_excel') }}" class="btn btn-primary">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="{{ url('/supplier/export_pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </a>
            <button onclick="modalAction('{{ url('/supplier/create_ajax') }}')" class="btn btn-success">
                <i class="fas fa-plus-square mr-1"></i> Tambah Supplier (Ajax)
            </button>
        </div>
        
    </div>

    <div class="card-body">
        <!-- Filter (masih digunakan sesuai kebutuhan) -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="supplier_id" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="supplier_id" class="form-control form-control-sm" id="supplier_id">
                                <option value="">- Semua Supplier -</option>
                                @foreach($supplier as $item)
                                    <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih supplier untuk filter</small>
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

        <table class="table table-bordered table-sm table-striped table-hover" id="supplierTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
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

    var dataSupplier;

    $(document).ready(function () {
        dataSupplier = $('#supplierTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('supplier.list') }}",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d.supplier_id = $('#supplier_id').val();
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "supplier_nama", orderable: true, searchable: true },
                { data: "supplier_telepon", orderable: true, searchable: true },
                { data: "supplier_alamat", orderable: true, searchable: true },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ]
        });

        // Reload saat filter berubah
        $('#supplier_id').on('change', function () {
            dataSupplier.ajax.reload();
        });
    });
</script>
@endpush
