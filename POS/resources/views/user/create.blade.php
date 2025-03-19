@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah User</h2>
    <form action="{{ route('user.tambah.simpan') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="level_id" class="form-label">Level</label>
            <select name="level_id" class="form-control" required>
                @foreach ($levels as $level)
                    <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
