<?php
// Mengimpor class dan namespace yang dibutuhkan
namespace App\Http\Controllers; // Menggunakan class Controller bawaan Laravel

use App\Models\Item;            // Menggunakan model Item (berhubungan dengan tabel items)
use Illuminate\Http\Request;    // Menggunakan class Request untuk menangani input dari form

// Mendeklarasikan class ItemController yang mengextends Controller
class ItemController extends Controller 
{
    // Menampilkan semua item
    public function index()
    {
        $items = Item::all(); // Mengambil semua data dari tabel items
        return view('items.index', compact('items')); // Mengirim data ke view
    }

    // Menampilkan form untuk menambahkan item baru.
    public function create()
    {
        return view('items.create'); // Mengembalikan tampilan form untuk membuat item baru
    }

    // Menyimpan item baru ke database.
    public function store(Request $request)
    {
        $request->validate([ // Validasi input menggunakan Validator atau $request->validate
            'name' => 'required', // Nama item wajib diisi
            'description' => 'required', // Deskripsi item wajib diisi
        ]);
         
        //Item::create($request->all());
        //return redirect()->route('items.index');

        // Hanya masukkan atribut yang diizinkan
         Item::create($request->only(['name', 'description']));  // Menyimpan data ke tabel 'items' (hanya atribut yang diizinkan)
        return redirect()->route('items.index')->with('success', 'Item added successfully.'); // Mengarahkan kembali ke halaman index dengan pesan sukses
    }

    // Menampilkan detail item berdasarkan ID.
    public function show(Item $item)
    {
        return view('items.show', compact('item'));  // Mengembalikan tampilan untuk menampilkan detail item
    }

    //  Menampilkan form untuk mengedit item.
    public function edit(Item $item)
    {
        return view('items.edit', compact('item')); // Mengembalikan tampilan untuk form edit item
    }

    // Mengupdate data item ke database.
    public function update(Request $request, Item $item)
    {
        // Validasi input untuk memastikan kolom 'name' dan 'description' terisi
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
         
        //$item->update($request->all());
        //return redirect()->route('items.index');
        // Hanya masukkan atribut yang diizinkan
         $item->update($request->only(['name', 'description']));
        return redirect()->route('items.index')->with('success', 'Item updated successfully.'); // Mengarahkan kembali ke halaman index dengan pesan sukses
    }

    // Menghapus item dari database.
    public function destroy(Item $item) 
    {
        
       // return redirect()->route('items.index');
       $item->delete(); // Menghapus item dari database
       return redirect()->route('items.index')->with('success', 'Item deleted successfully.'); // Menghapus item dari database
    }
}
