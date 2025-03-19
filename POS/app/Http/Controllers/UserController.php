<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan semua user
    public function index() {
        $users = UserModel::with('level')->get();
        return view('user.index', compact('users'));
    }

    // Form tambah user
    public function tambah(){
        $levels = LevelModel::all(); // Ambil semua level untuk dropdown
        return view('user.create', compact('levels'));
    }

    // Simpan user baru
    public function tambah_simpan(Request $request) {
        $request->validate([
            'username' => 'required|unique:m_user,username|max:50',
            'nama' => 'required|max:255',
            'password' => 'required|min:5',
            'level_id' => 'required|exists:m_level,level_id'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'User berhasil ditambahkan');
    }

    // Form edit user
    public function ubah($id) {
        $user = UserModel::findOrFail($id);
        $levels = LevelModel::all(); // Ambil semua level untuk dropdown
        return view('user.edit', compact('user', 'levels'));
    }

    // Simpan perubahan user
    public function ubah_simpan($id, Request $request) {
        $user = UserModel::findOrFail($id);

        $request->validate([
            'username' => 'required|max:50|unique:m_user,username,'.$id.',user_id',
            'nama' => 'required|max:255',
            'password' => 'nullable|min:5',
            'level_id' => 'required|exists:m_level,level_id'
        ]);

        $user->username = $request->username;
        $user->nama = $request->nama;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->level_id = $request->level_id;
        $user->save();

        return redirect('/user')->with('success', 'User berhasil diperbarui');
    }

    // Hapus user
    public function hapus($id) {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return redirect('/user')->with('success', 'User berhasil dihapus');
    }
}
