<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index() {
        // //coba akses usermodel
        // $user = UserModel::all(); //ambil semua dari tabel m_user
        // return view('user', ['data' => $user]);

        //tambah data user dengan eloquent model
        // $data = [
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 4
        // ];
        // UserModel::insert($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::find(1);
        // $user = UserModel::where('level_id', 1)->first();
        // $user = UserModel::firstWhere('level_id', 1);
        // $user = UserModel::findOr(20, ['username', 'nama'], function() {
        //     abort(404);
        // });
        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        // $user = UserModel::where('level_id',2)->count();
        // dd($user);
        // return view('user', ['data' => $user]);
        $user = UserModel::create(
            [
                'username' => 'manager11',
                'nama' => 'Manager11',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],

        );
        $user->username = 'manager12';

        $user->save();

        $user->wasChanged(); //true
        $user->wasChanged('username'); //true
        $user->wasChanged(['username','level_id']); //true
        $user->wasChanged('nama'); //false
        dd($user->wasChanged(['nama','username'])); //true

    }
}
