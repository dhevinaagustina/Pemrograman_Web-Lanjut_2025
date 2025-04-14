@empty($transaksi)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data transaksi yang Anda cari tidak ditemukan
            </div>
            <a href="{{ route('transaksi.index') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>Kode Transaksi</th>
                    <td>{{ $transaksi->penjualan_kode }}</td>
                </tr>
                <tr>
                    <th>Pembeli</th>
                    <td>{{ $transaksi->pembeli }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $transaksi->penjualan_tanggal }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>Rp {{ number_format($transaksi->penjualan_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Tutup</button>
        </div>
    </div>
</div>
@endempty
