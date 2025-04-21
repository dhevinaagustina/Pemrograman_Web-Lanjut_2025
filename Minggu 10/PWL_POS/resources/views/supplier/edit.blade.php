{{-- Halaman Edit Supplier --}}
@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Edit Supplier</h1>

    @isset($supplier)
        <form method="POST" action="{{ route('supplier.update', $supplier->supplier_id) }}" class="form-horizontal">
            @csrf
            @method('PUT')
            
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Nama Supplier</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="supplier_nama" name="supplier_nama" value="{{ old('supplier_nama', $supplier->supplier_nama) }}" required>
                    @error('supplier_nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Kontak</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="supplier_telepon" name="supplier_telepon" value="{{ old('supplier_telepon', $supplier->supplier_telepon) }}" required>
                    @error('supplier_telepon')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Alamat</label>
                <div class="col-10">
                    <textarea class="form-control" id="supplier_alamat" name="supplier_alamat" required>{{ old('supplier_alamat', $supplier->supplier_alamat) }}</textarea>
                    @error('supplier_alamat')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label"></label>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ route('supplier.index') }}">Kembali</a>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-danger">Data Supplier tidak ditemukan.</div>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
    @endisset
</div>
@endsection
