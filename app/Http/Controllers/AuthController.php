<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('loginui');
    }
    public function register(){
        $kelas = Group::all();
        return view('register', compact('kelas'));
    }
    public function prosesRegister(Request $request){
        $validasi = $request->validate([
            'nis' => 'required|unique:students',
            'name' => 'required',
            'jenkel' => 'required',
            'id_kelas' => 'required',
            'no_hp' => 'required|unique:students',
        ]);
        
        $user = User::create([
            'name' => ucwords($request->name),
            'username' => strtolower(str_replace(' ','', $request->name)).rand(100,999),
            'password' => bcrypt($request->nis),
            'level' => 'siswa',
            'acc' => 'n'
        ]);
        $siswa = Student::create([
            'nis' => $request->nis,
            'id_user' => $user->id,
            'id_kelas' => $request->id_kelas,
            'jenkel' => $request->jenkel,
            'no_hp' => $request->no_hp
        ]);
        
        return redirect()->route('index')->with('status', 'Username : '.$user->username.' Password : '.$siswa->nis.' (CATAT)');
    }
    public function login(Request $request )
    {
        if(Auth::attempt($request->only('username', 'password'))){
            Auth::user();
            return redirect()->route('index'.Auth::user()->level);
        }
        else {
            return redirect()->route('index');
        }
    }
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('index')->with('status', 'Anda berhasil logout');
    }
}
