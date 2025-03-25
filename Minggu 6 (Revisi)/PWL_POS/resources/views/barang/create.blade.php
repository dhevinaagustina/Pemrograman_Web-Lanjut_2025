@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Barang</h3>
            <div class="card-tools">
                <a href="{{ url('barang') }}" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('barang') }}">
                @csrf
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" name="barang_kode" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="barang_nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
