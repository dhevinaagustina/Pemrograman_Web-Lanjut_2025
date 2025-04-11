@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <table id="table-transaksi" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-show" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal-content-show"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    $('#table-transaksi').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('transaksi.list') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'penjualan_kode' },
            { data: 'pembeli' },
            { data: 'penjualan_tanggal' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});

function showDetail(id) {
    $.get('/transaksi/' + id + '/show_ajax', function(data) {
        $('#modal-content-show').html(data);
        $('#modal-show').modal('show');
    });
}
</script>
@endpush
