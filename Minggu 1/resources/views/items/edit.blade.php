<!DOCTYPE html> 
<html lang="en"> 
<head>
    <title>Edit Item</title> <!-- Menentukan judul halaman yang ditampilkan di tab browser -->
</head>
<body>
    <h1>Edit Item</h1> <!-- Menampilkan judul halaman sebagai "Edit Item" -->

    <!-- Membuat form dengan method POST dan route untuk update item -->
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf <!-- Menambahkan token CSRF untuk melindungi form dari serangan CSRF -->
        @method('PUT') <!-- Menggunakan metode PUT karena kita ingin memperbarui data item yang sudah ada -->
        
        <!-- Label untuk input nama item -->
        <label for="name">Name:</label>
        
        <!-- Input teks untuk nama item, dengan nilai default menggunakan data item yang sedang diedit -->
        <input type="text" name="name" value="{{ $item->name }}" required>
        <br>

        <!-- Label untuk input deskripsi item -->
        <label for="description">Description</label>
        
        <!-- Textarea untuk deskripsi item, dengan nilai default menggunakan data deskripsi item yang sedang diedit -->
        <textarea name="description" required>{{ $item->description }}</textarea>
        <br>

        <!-- Tombol untuk mengirimkan form untuk memperbarui item -->
        <button type="submit">Update Item</button>
    </form>

    <!-- Link untuk kembali ke daftar item (halaman index) -->
    <a href="{{ route('items.index') }}">Back to List</a>

</body>
</html>
