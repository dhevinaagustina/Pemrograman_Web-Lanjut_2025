<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <table border="1">
        <tr>
            <th>Jumlah Pengguna</th>
            {{-- <th>ID</th>
            <tb>Username</tb>
            <tb>Nama</tb>
            <tb>ID Level Pengguna</tb> --}}
        </tr>
        {{-- @foreach ($data as $user) --}}
            <tr>
                <td>{{ $jumlahUser }}</td>
                {{-- <td>{{ $user->user_id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->level_id }}</td> --}}
                {{-- <td>{{ $data->user_id }}</td>
                <td>{{ $data->username }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->level_id }}</td> --}}
            </tr>
        {{-- @endforeach --}}
    </table>
</body>
</html>