<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\LogCheat;
use App\Models\LogExam;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class ExamController extends Controller
{
    public function indexsiswa(){
        return view('exam.indexexam');
    }

    public function listTest(){
        $siswa = DB::table('students')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->where('students.id_user', Auth::user()->id)
        ->first();
        $data = DB::table('exams')
        ->where('acc', 'y')
        ->where('id_kelas', $siswa->id_kelas)
        ->get();
        if(Auth::user()->acc == 'n'){
            return redirect()->route('index')->with('gagal', 'Akun anda belum di verifikasi');
        } else {
            return view('exam.list-test',compact('data'));
        }
        
    }
    public function token($id){
        $data = DB::table('exams')
        ->where('id_ujian', $id)
        ->first();
        return view('exam.token', compact('data'));
    }
    public function masukUjian(Request $request){
        $tokenini = $request->ctoken;
        $rtoken = $request->token;
        $id_ujian = $request->id_ujian;

        if($rtoken == $tokenini){
            $test = DB::table('exams')->where('id_ujian',$id_ujian)->first();
            $data = DB::table('students')
            ->leftJoin('groups','groups.id_kelas','students.id_kelas')
            ->where('id_user', Auth::user()->id)
            ->first();
            if(Session::get('start') == null){
                Session::put('start', time());
            }
            Session::put('id_ujian', $id_ujian);
            Session::put('nama_ujian', $test->nama_ujian);
            Session::put('nama_kelas',$data->nama_kelas);
            $end = Session::get('start') + $test->waktu * 60 *1000;
            $sisa = $end - time();
            $cek = LogExam::where('id_ujian', Session::get('id_ujian'))
        ->where('id_user', Auth::user()->id)
        ->count();
        
        if( $cek < 1){
            return redirect()->route('test');
        } else {
            Auth::logout();
        Session::flush();
            return redirect()->route('index')->with('status', 'Anda sudah menyelesaikan Test tersebut');
        }
           
            // return redirect()->route('test');
        } else {
            Auth::logout();
            return redirect()->route('index')->with('gagal', 'Kode Token Salah');
        }
    }
    public function test(){
        $id = Session::get('id_ujian');
        $test = DB::table('exams')->where('id_ujian',$id)->first();
        return view('exam.test', compact('test'));
        
        
    }
    public function getWaktu(){
        $waktuUjian = 30;
        $start = Session::put('start', time());
        $waktuTersisa = Session::get('start') - time();

        return 120;
    }
    public function done(){
        LogExam::create([
            'id_ujian' => Session::get('id_ujian'),
            'id_user' => Auth::user()->id,
            'nama' => Auth::user()->name,
            'nama_kelas' => Session::get('nama_kelas'),
            'nama_ujian' => Session::get('nama_ujian')
        ]);

        Auth::logout();
        Session::flush();
        return redirect()->route('index')->with('status', 'Anda berhasil logout');
    }
    public function logc(){
        $cek = LogCheat::where('id_ujian', Session::get('id_ujian'))
                        ->where('id_user', Auth::user()->id)
                        ->count();
        if($cek < 1) {
            LogCheat::create([
                'id_ujian' => Session::get('id_ujian'),
                'id_user' => Auth::user()->id,
            ]);
            $nama = Auth::user()->name;
            $tokenTelegram = '6019753763:AAGy5F-9h3jAKgLM38AhaiIM5LZ3oyYfXFM';
            $grupId = -926083732;
            $kelas = Session::get('nama_kelas');
            $ujian = Session::get('nama_ujian');
            $text = $nama." dari kelas ".$kelas." dalam ujian ".$ujian;
            Http::get('https://api.telegram.org/bot'.$tokenTelegram.'/sendMessage?chat_id='.$grupId.'&text='.$text." terdeteksi melakukan kecurangan.");
        }
        return redirect()->route('test');
    }
    public function printLogC($id){
        $data = DB::table('log_cheats')
        ->leftJoin('students','students.id_user', 'log_cheats.id_user')
        ->leftJoin('users','users.id','students.id_user')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->leftJoin('exams','exams.id_ujian','log_cheats.id_ujian')
        ->orderBy('exams.nama_ujian', 'asc')
        ->where('students.id_kelas', $id)
        ->get();
        $kelas = Group::where('id_kelas', $id)->first();
        $pdf = Pdf::loadView('pdf.logc', compact('data','kelas'));
        return $pdf->stream('log-kecurangan.pdf');
    }
    
}
