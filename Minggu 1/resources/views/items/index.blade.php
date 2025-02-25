<!DOCTYPE html> 
<html> 
<head>
    <title>Item List</title> <!-- Menentukan judul halaman yang ditampilkan di tab browser -->
</head>
<body>
    <h1>Items</h1> <!-- Menampilkan judul utama halaman sebagai "Items" -->

    <!-- Menampilkan pesan sukses jika ada pesan dari session -->
    @if(session('success'))
        <p>{{ session('success') }}</p> <!-- Menampilkan pesan sukses yang disimpan di session -->
    @endif

    <!-- Link untuk menuju halaman form tambah item -->
    <a href="{{ route('items.create') }}">Add Item</a>

    <ul>
        <!-- Looping melalui semua item dan menampilkan dalam daftar -->
        @foreach ($items as $item)
            <li>
                <!-- Menampilkan nama item -->
                {{ $item->name }} - 
                <!-- Link untuk menuju halaman edit item berdasarkan ID item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a>
                
                <!-- Form untuk menghapus item dengan metode DELETE -->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf <!-- Menambahkan token CSRF untuk melindungi form dari serangan CSRF -->
                    @method('DELETE') <!-- Menggunakan metode DELETE karena kita ingin menghapus item -->
                    <button type="submit">Delete</button> <!-- Tombol untuk menghapus item -->
                </form>
            </li>
        @endforeach
    </ul>

</body>
</html>
