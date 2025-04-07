@extends('layouts.template')

@section('content')
<div class="container">
    <h3>Edit Profil Saya</h3>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Menampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Foto Saat Ini</label><br>
            @if ($user->foto)
                <img src="{{ asset('storage/uploads/user/' . $user->foto) }}" width="150" class="img-thumbnail">
            @else
                <p class="text-muted">Belum ada foto.</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Pilih Foto Baru</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ url('/user') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
