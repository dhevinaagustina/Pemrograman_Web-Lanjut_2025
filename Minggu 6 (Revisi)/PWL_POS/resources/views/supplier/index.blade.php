@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Supplier</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('supplier.create') }}">Tambah Supplier</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="supplier_id" name="supplier_id">
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

            <table class="table table-bordered table-striped table-hover table-sm" id="supplierTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
<!-- Bisa tambahkan CSS jika diperlukan -->
@endpush

@push('js')
<script>
    $(document).ready(function() {
        var dataSupplier = $('#supplierTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('supplier.list') }}", // Pastikan route ini benar
                "type": "POST",
                "dataType": "json",
                "data": function (d) {
                    d.supplier_id = $('#supplier_id').val();
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "supplier_nama", className: "", orderable: true, searchable: true },
                { data: "supplier_telepon", className: "", orderable: true, searchable: true },
                { data: "supplier_alamat", className: "", orderable: true, searchable: true },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ]
        });

        // Filter berdasarkan dropdown supplier
        $('#supplier_id').on('change', function(){
            dataSupplier.ajax.reload();
        });
    });
</script>
@endpush
