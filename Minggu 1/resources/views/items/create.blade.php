<!DOCTYPE html> 
<html lang="en"> 
<head>
    <title>Add Items</title> <!-- Menentukan judul halaman yang ditampilkan di tab browser -->
</head>
<body>
    <h1>Add Item</h1> <!-- Menampilkan judul halaman sebagai "Add Item" -->

    <!-- Membuat form dengan method POST untuk mengirim data ke server -->
    <form action="{{ route('items.store') }}" method="POST">
        @csrf <!-- Menambahkan token CSRF untuk melindungi form dari serangan CSRF -->
        
        <!-- Label untuk input nama item -->
        <label for="name">Name:</label>
        
        <!-- Input teks untuk nama item yang wajib diisi -->
        <input type="text" name="name" required>
        <br>

        <!-- Label untuk input deskripsi item -->
        <label for="description">Description</label>
        
        <!-- Textarea untuk deskripsi item yang wajib diisi -->
        <textarea name="description" required></textarea>
        <br>

        <!-- Tombol untuk mengirimkan form -->
        <button type="submit">Add Item</button>
    </form>

    <!-- Link untuk kembali ke daftar item (halaman index) -->
    <a href="{{ route('items.index') }}">Back to List</a>

</body>
</html>
