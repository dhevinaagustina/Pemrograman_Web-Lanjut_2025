{{-- Halaman Detail Supplier --}}
@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Detail Supplier</h1>
    
    @isset($supplier)
        <table class="table table-bordered">
            <tr>
                <th>Nama Supplier</th>
                <td>{{ $supplier->supplier_nama }}</td>
            </tr>
            <tr>
                <th>Kontak</th>
                <td>{{ $supplier->supplier_telepon }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $supplier->supplier_alamat }}</td>
            </tr>
        </table>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('supplier.edit', $supplier->supplier_id) }}" class="btn btn-warning">Edit</a>
        <form method="POST" action="{{ route('supplier.destroy', $supplier->supplier_id) }}" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</button>
        </form>
    @else
        <div class="alert alert-danger">Data Supplier tidak ditemukan.</div>
    @endisset
</div>
@endsection

{{-- Halaman Detail Level --}}
@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @isset($level)
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $level->id }}</td>
                    </tr>
                    <tr>
                        <th>Kode Level</th>
                        <td>{{ $level->level_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Level</th>
                        <td>{{ $level->level_name }}</td>
                    </tr>
                </table>
                <a href="{{ route('level.index') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @endisset
        </div>
    </div>
@endsection
