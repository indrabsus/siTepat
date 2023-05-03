<?php

namespace App\Http\Controllers;

use App\Models\Graduation;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function cekSkl(){
        return view('cekskl');
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
    
}
