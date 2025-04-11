@extends('layouts.template')

@section('content')
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">Edit Stok</h3>
            <div class="card-tools">
                <a href="{{ url('stok') }}" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('stok/' . $stok->stok_id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Pilih Barang</label>
                    <select name="barang_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->barang_id }}" {{ $stok->barang_id == $b->barang_id ? 'selected' : '' }}>
                                {{ $b->barang_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Stok</label>
                    <input type="datetime-local" name="stok_tanggal" class="form-control" 
                        value="{{ \Carbon\Carbon::parse($stok->stok_tanggal)->format('Y-m-d\TH:i:s') }}" required>
                </div>

                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="stok_jumlah" class="form-control" value="{{ $stok->stok_jumlah }}" required>
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
            </form>
        </div>
    </div>
@endsection
