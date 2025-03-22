@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Level</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('level/create') }}">Tambah Level</a>
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
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -</option>
                                @foreach($level as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Level</th>
                        <th>Nama Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endsection

    @push('css') 
    <!-- Bisa ditambahkan CSS jika diperlukan -->
    @endpush

    @push('js')
    <script>
        $(document).ready(function() {
            var dataLevel = $('#table_level').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('level/list') }}", // Pastikan route ini ada di backend
                    "type": "POST",
                    "dataType": "json",
                    "data": function (d) {
                    d.level_id = $('#level_id').val();
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "level_kode", className: "", orderable: true, searchable: true },
                    { data: "level_name", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
            $('#level_id').on('change', function(){
                dataUser.ajax.reload();
            })
        });
    </script> 
    @endpush
