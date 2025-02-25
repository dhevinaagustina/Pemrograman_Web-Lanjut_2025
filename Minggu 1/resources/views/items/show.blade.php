<!DOCTYPE html> 
<html> 
<head>
    <title>Item List</title> <!-- Menentukan judul halaman yang ditampilkan di tab browser -->
</head>
<body>
    <h1>Items</h1> <!-- Menampilkan judul utama halaman sebagai "Items" -->

    <!-- Mengecek apakah ada pesan sukses dalam session -->
    @if(session('success'))
        <p>{{ session('success') }}</p> <!-- Menampilkan pesan sukses yang ada dalam session -->
    @endif

    <!-- Link untuk menuju halaman tambah item -->
    <a href="{{ route('items.create') }}">Add Item</a>

    <ul>
        <!-- Melakukan loop untuk setiap item yang ada dalam variabel $items -->
        @foreach ($items as $item)
            <li>
                <!-- Menampilkan nama item -->
                {{ $item->name }} - 

                <!-- Link untuk menuju halaman edit item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a>

                <!-- Formulir untuk menghapus item, menggunakan metode POST dan disertakan metode DELETE -->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf <!-- Menambahkan token CSRF untuk melindungi form dari serangan CSRF -->
                    @method('DELETE') <!-- Menggunakan metode DELETE untuk menghapus item -->
                    <button type="submit">Delete</button> <!-- Tombol untuk menghapus item -->
                </form>
            </li>
        @endforeach
    </ul>

</body>
</html>
