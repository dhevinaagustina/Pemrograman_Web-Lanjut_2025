@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar User</h2>
    <a href="{{ url('/user/tambah') }}" class="btn btn-primary">Tambah User</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->level->level_name ?? 'Tidak Diketahui' }}</td>
                <td>
                    <a href="{{ url('/user/ubah/'.$user->id) }}" class="btn btn-warning">Ubah</a>
                    <form action="{{ route('user.hapus', $user->user_id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
