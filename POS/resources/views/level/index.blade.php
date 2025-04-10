@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Level</h3>
        <div class="card-tools d-flex flex-wrap gap-2">
            <button onclick="modalAction('{{ url('/level/import') }}')" class="btn btn-info">
                <i class="fas fa-file-import mr-1"></i> Import Level
            </button>
            <a href="{{ url('/level/export_excel') }}" class="btn btn-primary">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="{{ url('/level/export_pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </a>
            <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-success">
                <i class="fas fa-plus-square mr-1"></i> Tambah Level (Ajax)
            </button>
        </div>
        
    </div>

    <div class="card-body">
        <!-- Filter -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="filter_level" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="filter_level" class="form-control form-control-sm filter_level" id="filter_level">
                                <option value="">- Semua -</option>
                                @foreach($level as $l)
                                    <option value="{{ $l->level_id }}">{{ $l->level_name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
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

        <table class="table table-bordered table-sm table-striped table-hover" id="table-level">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Level</th>
                    <th>Nama Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').html('');
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function () {
        var tableLevel = $('#table-level').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('level/list') }}",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d.level_id = $('#filter_level').val();
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "level_kode",
                    width: "20%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "level_name",
                    width: "55%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "text-center",
                    width: "20%",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#filter_level').on('change', function () {
            tableLevel.ajax.reload();
        });

        $('#table-level_filter input').unbind().bind().on('keyup', function (e) {
            if (e.keyCode == 13) {
                tableLevel.search(this.value).draw();
            }
        });
    });
</script>
@endpush
