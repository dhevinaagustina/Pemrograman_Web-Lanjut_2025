@extends('layouts.template')

@section('content')
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Detail Barang</h3>
            <div class="card-tools">
                <a href="{{ url('barang') }}" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $barang->barang_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $barang->barang_nama }}</td>
                </tr>
                <tr>
                    <th>Harga Beli</th>
                    <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Harga Jual</th>
                    <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
