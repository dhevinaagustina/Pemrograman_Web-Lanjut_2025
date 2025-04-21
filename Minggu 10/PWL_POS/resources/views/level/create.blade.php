@extends('layouts.template')

@section('content')
<div class="container">
    <h3>Tambah Level</h3>
    <form action="{{ route('level.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="level_kode" class="form-label">Kode Level</label>
            <input type="text" class="form-control" name="level_kode" required>
        </div>
        <div class="mb-3">
            <label for="level_name" class="form-label">Nama Level</label>
            <input type="text" class="form-control" name="level_name" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('level.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
