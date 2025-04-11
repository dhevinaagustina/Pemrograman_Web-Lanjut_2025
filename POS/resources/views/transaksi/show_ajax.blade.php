<div class="modal-header">
    <h5 class="modal-title">{{ $page->title }}</h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    @isset($transaksi)
    <table class="table table-bordered">
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
            <td>{{ \Carbon\Carbon::parse($transaksi->penjualan_tanggal)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <th>Kasir</th>
            <td>{{ $transaksi->user->name ?? '-' }}</td>
        </tr>
    </table>

    <h6>Detail Barang:</h6>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $detail)
            <tr>
                <td>{{ $detail->barang->barang_nama ?? '-' }}</td>
                <td>{{ number_format($detail->harga) }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>{{ number_format($detail->harga * $detail->jumlah) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="alert alert-danger">Data transaksi tidak ditemukan.</div>
    @endisset
</div>
