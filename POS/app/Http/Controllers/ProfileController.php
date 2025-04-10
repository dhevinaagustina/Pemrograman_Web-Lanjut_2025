<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserModel;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        return view('profile.edit', [
            'user' => $user,
            'activeMenu' => 'profile',
            'breadcrumb' => (object)[
                'title' => 'Profil Saya',
                'list' => [
                    route('dashboard'),
                    'Profil'
                ]
            ]
        ]);
    }

    


    public function update(Request $request)
    {
        /** @var \App\Models\UserModel $user */
        $user = Auth::user();

        // Validasi file
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika ada file foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/uploads/user/' . $user->foto)) {
                Storage::delete('public/uploads/user/' . $user->foto);
            }

            // Simpan foto baru
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads/user', $filename);

            $user->foto = $filename;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Foto profil berhasil diperbarui.');
    }
}

