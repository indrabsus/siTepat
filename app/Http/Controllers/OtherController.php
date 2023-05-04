<?php

namespace App\Http\Controllers;

use App\Models\Graduation;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function cekSkl(){
        return view('cekskl');
    }
    public function cekSkl2(){
        return view('cekskl2');
    }

    public function sklproses(Request $request){
        $request->validate([
            'nis' => 'required',
            'password' => 'required'
        ]);
        $data = Graduation::where('nis', $request->nis)->first();
        if($data != null){
            if($request->password == $data->password){
                return view('skl', compact('data'));
            } else {
                return redirect()->route('cekSkl')->with('gagal', 'Data tidak ditemukan');
            }
        } else {
            return redirect()->route('cekSkl')->with('gagal', 'Data tidak ditemukan');
        }
        
    }
    
    public function generate(){
        Graduation::where('id_kelulusan','>',0)->update([
            'password' => rand(10000,99999)
        ]);
        return redirect()->route('graduationmgmt')->with('berhasil', 'Berhasil Acak Password');
    }
    
}
